bootTargetScript();

/**
 * Boot the target script
 */
async function bootTargetScript() {
    let url = new URL(document.currentScript.src);
    let reference = url.searchParams.get('ref');

    await fetch(`${url.origin}/api/domains/${reference}`)
        .then((response) => response.json())
        .then((data) => {
            let domain = data.data.domain;

            if (confirmTargetDomain(domain.base_url)) {
                applyTargetRulesToApp(domain.rules);
            }
        })
        .catch((error) => {
            console.error('Script not installed correctly.', error)
        });
}

/**
 * Validate the rules are installed on the correct domain.
 *
 * @param {string} url
 * @returns Boolean
 */
function confirmTargetDomain(url) {
    return window.location.host === new URL(url).host;
}

/**
 * Apply the rules to the page.
 *
 * @param {array} rules
 */
function applyTargetRulesToApp(rules) {
    let currentAppPath = window.location.pathname;

    let alerts = rules.filter((rule) => currentAppPath.includes(rule.page) || rule.page == null);

    let alertsToShow = targetRulesChecker(currentAppPath, alerts);

    alertsToShow
        .filter((value, index, self) => index === self.findIndex((alertToShow) => alertToShow.alert_text === value.alert_text))
        .forEach((alertToShow) => {
            let similarAlerts = targetRulesChecker(
                currentAppPath,
                alerts.filter((a) => a.alert_text == alertToShow.alert_text),
                false
            );

            if (similarAlerts.length && similarAlerts.every((a) => a.show_alert == true)) {
                alert(alertToShow.alert_text);
            }
        });
}

/**
 * Validate the 'contains' target rule.
 *
 * @param {string} path
 * @param {string} page
 * @returns Boolean
 */
function targetRuleContains(path, page) {
    return path.includes(page);
}

/**
 * Validate the 'exact' target rule.
 *
 * @param {string} path
 * @param {string} page
 * @returns Boolean
 */
function targetRuleExact(path, page) {
    return path == page;
}

/**
 * Validate the 'starts_with' target rule.
 *
 * @param {string} path
 * @param {string} page
 * @returns Boolean
 */
function targetRuleStartsWith(path, page) {
    return path.startsWith(page);
}

/**
 * Validate the 'ends_with' target rule.
 *
 * @param {string} path
 * @param {string} page
 * @returns Boolean
 */
function targetRuleEndsWith(path, page) {
    return path.endsWith(page);
}

/**
 * Check path in alerts against the different rules.
 *
 * @param {string} path
 * @param {array} alerts
 * @param {boolean} checkAlertStatus check if rule was set to show or not
 * @returns array
 */
function targetRulesChecker(path, alerts, checkAlertStatus = true) {
    let result = [];

    alerts.forEach((alert) => {
        let page = alert.page ? alert.page : '';

        if (alert.show_alert || checkAlertStatus == false) {
            if (alert.rule === 'contains' && targetRuleContains(path, page)) {
                result.push(alert);
            } else if (alert.rule === 'exact' && targetRuleExact(path.replace('/', ''), page)) {
                result.push(alert);
            } else if (alert.rule === 'starts_with' && targetRuleStartsWith(path.replace('/', ''), page)) {
                result.push(alert);
            } else if (alert.rule === 'ends_with' && targetRuleEndsWith(path, page)) {
                result.push(alert);
            }
        } else {
            if (checkAlertStatus) {
                if (alert.rule === 'contains' && targetRuleContains(path, page)) {
                    result.splice(result.findIndex((alert) => alert.id === alert.id), 1);
                } else if (alert.rule === 'exact' && targetRuleExact(path.replace('/', ''), page)) {
                    result.splice(result.findIndex((alert) => alert.id === alert.id), 1);
                } else if (alert.rule === 'starts_with' && targetRuleStartsWith(path.replace('/', ''), page)) {
                    result.splice(result.findIndex((alert) => alert.id === alert.id), 1);
                } else if (alert.rule === 'ends_with' && targetRuleEndsWith(path, page)) {
                    result.splice(result.findIndex((alert) => alert.id === alert.id), 1);
                }
            }
        }
    });

    return result;
}
