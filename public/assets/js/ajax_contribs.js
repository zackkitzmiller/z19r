/**
 * Pull contributor info by repo and spit out contributor list to page
 *
 * @return {object} API
 */
var githubContributors = (function() {
    var init, _makeAjaxCall, _generateUserLi,
    contrib_url = '/contributors',
    contrib_container_id = 'contributors';

    init = function() {
        _makeAjaxCall(
            // 'https://api.github.com/repos/zackkitzmiller/z19r/contributors',
            contrib_url,
            function(data) {
                var $contrib_list = document.getElementById(contrib_container_id),
                    contributor,
                    new_contrib;

                data = JSON.parse(data);
                for (var contributor_index in data) {
                    contributor = data[contributor_index];

                    $contrib_list.appendChild(_generateUserLi(contributor));
                }
            }
        );
    };

    /**
     * Make a simple Ajax call
     *
     * @param  {string}   url
     * @param  {Function} callback
     * @param  {string}   method     HTTP method
     * @param  {string}   gob bluth  METHOD ONE clinic
     */
    _makeAjaxCall = function(url, callback, method) {
        var xmlhttp = new XMLHttpRequest();

        if (typeof method === 'undefined') {
            method = 'GET';
        }

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 200) {
                callback(xmlhttp.responseText);
            } else {
                console.log(xmlhttp.status + ' error returned.');
            }
            }
        };

        xmlhttp.open(method, url, true);
        xmlhttp.setRequestHeader('Accept', 'application/vnd.github.v3+json');
        xmlhttp.send();
    };

    /**
     * Generate a user <li> from a github contributor
     *
     * @param  {object} contributor Contributor from Github API
     * @return {DOM node}           <li>
     */
    _generateUserLi = function(contributor) {
        var li = document.createElement('li');
        li.innerHTML = '<a href="' + contributor.html_url + '">' + contributor.login + '</a> <span class="contribution-count">(' + contributor.contributions + ')</span>';
        return li;
    };

    return {
        init: init
    };
})();

githubContributors.init();
