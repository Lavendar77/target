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
        .catch(() => {
            console.error('Script not installed correctly.')
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

    rules.forEach((rule) => {
        //
    })
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
