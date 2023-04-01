export class DomainRuleGroup {
    constructor(text = '', rules = []) {
        this.alert_text = text,
        this.rules = rules.length ? rules : [new DomainRule()]
    }
};

export class DomainRule {
    constructor() {
        this.show_alert = 1,
        this.rule = '',
        this.page = ''
    }
}
