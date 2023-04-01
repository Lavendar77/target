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
            applyTargetRulesToApp(data.data.domain.rules);
        })
        .catch(() => {
            console.error('Script not installed correctly.')
        });
}

/**
 * Apply the rules to the page.
 *
 * @param {Array} rules
 */
function applyTargetRulesToApp(rules) {

}
