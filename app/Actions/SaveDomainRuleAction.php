<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\DomainRule;
use Illuminate\Support\Facades\DB;

class SaveDomainRuleAction
{
    /**
     * Create domain rules.
     *
     * @param string|int $domainId
     * @param array<int, mixed> $domainRules
     * @return void
     */
    public function create(string|int $domainId, array $domainRules)
    {
        $data = [];
        $now = now();

        foreach ($domainRules as $domainRule) {
            $alertText = $domainRule['alert_text'];

            $rules = $domainRule['rules'];

            foreach ($rules as $rule) {
                $data[] = [
                    'domain_id' => $domainId,
                    'alert_text' => $alertText,
                    'page' => $rule['page'],
                    'show_alert' => $rule['show_alert'],
                    'rule' => $rule['rule'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::transaction(function () use ($domainId, $data) {
            DomainRule::query()->where('domain_id', $domainId)->delete();
            DomainRule::query()->insert($data);
        });
    }
}
