var share = {

	twitter: function($this){

		var data = share.data($this);

		if(data){

			var url  = "http://twitter.com/share?";
				url += "text="      + encodeURIComponent(data.text);
				url += "&url="      + encodeURIComponent(data.url);
				url += "&hashtags=" + "";
				url += "&counturl=" + encodeURIComponent(data.url);

			share.popup(url);
		};

		return false;
	},
	vk: function($this){

		var data = share.data($this);

		if(data){

			var url  = 'http://vkontakte.ru/share.php?';
				url += 'url='          + encodeURIComponent(data.url);
				url += '&title='       + encodeURIComponent(data.title);
				url += '&description=' + encodeURIComponent(data.text);
				url += '&image='       + encodeURIComponent(data.img);
				url += '&noparse=true';

			share.popup(url);
		};

		return false;
	},
	facebook: function($this){

		var data = share.data($this);

		if(data){

			var url  = 'http://www.facebook.com/sharer.php?s=100';
				url += '&p[title]='     + encodeURIComponent(data.title);
				url += '&p[summary]='   + encodeURIComponent(data.text);
				url += '&p[url]='       + encodeURIComponent(data.url);
				url += '&p[images][0]=' + encodeURIComponent(data.img);

			share.popup(url);
		};

		return false;
	},
	data: function($this){

		if($this){

			return $.parseJSON($this.parent("div").attr("data-share-data"));
		};

		return false;
	},
	popup: function(url){

		window.open(url, "", "toolbar=0, status=0, width=626, height=436");

		return false;
	}
};