var config = {
    env: 'staging',
    api: {
        base_url: 'http://'+location.host+':'+location.port+'/api',
        defaultRequest: {
            headers: {
                'X-Requested-With': 'rest.js',
                'Content-Type': 'application/json'
            }
        }
    },
    social: {
        facebook: '',
        twitter: '',
        github: ''
    },
    debug: true
}
module.exports = config
