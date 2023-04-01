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
    let alertsToShow = [];

    alerts.forEach((alert) => {
        let page = alert.page ? alert.page : '';

        if (alert.show_alert) {
            if (alert.rule === 'contains' && targetRuleContains(currentAppPath, page)) {
                alertsToShow.push({
                    id: alert.id,
                    text: alert.alert_text,
                });
            } else if (alert.rule === 'exact' && targetRuleExact(currentAppPath.replace('/', ''), page)) {
                alertsToShow.push({
                    id: alert.id,
                    text: alert.alert_text,
                });
            } else if (alert.rule === 'starts_with' && targetRuleStartsWith(currentAppPath.replace('/', ''), page)) {
                alertsToShow.push({
                    id: alert.id,
                    text: alert.alert_text,
                });
            } else if (alert.rule === 'ends_with' && targetRuleEndsWith(currentAppPath, page)) {
                alertsToShow.push({
                    id: alert.id,
                    text: alert.alert_text,
                });
            }
        } else {
            if (alert.rule === 'contains' && targetRuleContains(currentAppPath, page)) {
                alertsToShow.splice(alertsToShow.findIndex((alert) => alert.id === alert.id), 1);
            } else if (alert.rule === 'exact' && targetRuleExact(currentAppPath.replace('/', ''), page)) {
                alertsToShow.splice(alertsToShow.findIndex((alert) => alert.id === alert.id), 1);
            } else if (alert.rule === 'starts_with' && targetRuleStartsWith(currentAppPath.replace('/', ''), page)) {
                alertsToShow.splice(alertsToShow.findIndex((alert) => alert.id === alert.id), 1);
            } else if (alert.rule === 'ends_with' && targetRuleEndsWith(currentAppPath, page)) {
                alertsToShow.splice(alertsToShow.findIndex((alert) => alert.id === alert.id), 1);
            }
        }
    });

    alertsToShow.forEach((alertToShow) => {
        alert(alertToShow.text);
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
