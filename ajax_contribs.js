var githubContributors = (function() {
    var init, _makeAjaxCall, _generateUserLi;

    init = function() {
	_makeAjaxCall(
	    'https://api.github.com/repos/zackkitzmiller/z19r/contributors',
	    function(data) {
		var $contrib_list = document.getElementById("contributors"),
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