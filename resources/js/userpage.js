$(function(){
	// ツイートの編集ボタンが押された時にフォームを作成する
	$('a.edit_tweet').click(function(){
		createEditTweetForm($(this).parents('.tweet'));
		return false;
	});

	// ツイートの削除ボタンが押された時
	$('a.delete_tweet').click(function(){
		// フォームの値を変更
		removeTweet($(this).parents('.tweet').data('tweet_id'));
		return false;
	});

});

// 受け取ったdiv.tweetに編集フォームを作る
function createEditTweetForm(div_tweet){
	var tweet_id = $(div_tweet).data('tweet_id');
	var div_tweet_body = $(div_tweet).find(".tweet_body");
	var csrf_token = $('meta[name=csrf-token]').attr('content');
	var form = $('<form>', {method: 'post', action: '/tweet/edit'})
			.append($('<input>', {type: 'hidden', name: '_token', value: csrf_token}))
			.append($('<input>', {type: 'hidden', name: 'tweet_id', value: tweet_id}))
			.append($('<textarea>', {name: 'tweet_body'}).val(div_tweet_body.text()))
			.append($('<input>', {type: 'submit', value: '更新'}));
	div_tweet_body.html(form);
}

function editTweet(tweet_id, text){
	console.log(tweet_id+text);
}

// tweet_idを削除するPOSTを送信
function removeTweet(tweet_id){
	var csrf_token = $('meta[name=csrf-token]').attr('content');
	var form = $('<form>', {method: 'post', action: '/tweet/delete'})
			.append($('<input>', {type: 'hidden', name: '_token', value: csrf_token}))
			.append($('<input>', {type: 'hidden', name: 'tweet_id', value: tweet_id}));
	form.appendTo(document.body);
	form.submit();
	// あとでtarget指定とかした時用
	// form.remove();
}