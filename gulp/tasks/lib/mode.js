const argv = require('yargs').argv;

const action = (argv.action === undefined) ? 'build' : argv.action;
const site_key = (argv.site === undefined) ? 'woody-sandbox' : argv.site;
const env = (argv.env === undefined) ? 'dev' : argv.env;
const url = (argv.url === undefined) ? 'www.' + site_key + '.wp.rc-dev.com' : argv.url;
const light = (argv.light === undefined) ? false : true;

module.exports = {
    action: action,
    site_key: site_key,
    env: env,
    url: url,
    light: light
};
