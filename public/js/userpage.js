/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/userpage.js":
/*!**********************************!*\
  !*** ./resources/js/userpage.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  // ツイートの編集ボタンが押された時にフォームを作成する
  $('a.edit_tweet').click(function () {
    createEditTweetForm($(this).parents('.tweet'));
    return false;
  }); // ツイートの削除ボタンが押された時

  $('a.delete_tweet').click(function () {
    // フォームの値を変更
    removeTweet($(this).parents('.tweet').data('tweet_id'));
    return false;
  });
}); // 受け取ったdiv.tweetに編集フォームを作る

function createEditTweetForm(div_tweet) {
  var tweet_id = $(div_tweet).data('tweet_id');
  var div_tweet_body = $(div_tweet).find(".tweet_body");
  var csrf_token = $('meta[name=csrf-token]').attr('content');
  var form = $('<form>', {
    method: 'post',
    action: '/tweet/edit'
  }).append($('<input>', {
    type: 'hidden',
    name: '_token',
    value: csrf_token
  })).append($('<input>', {
    type: 'hidden',
    name: 'tweet_id',
    value: tweet_id
  })).append($('<textarea>', {
    name: 'tweet_body'
  }).val(div_tweet_body.text())).append($('<input>', {
    type: 'submit',
    value: '更新'
  }));
  div_tweet_body.html(form);
}

function editTweet(tweet_id, text) {
  console.log(tweet_id + text);
} // tweet_idを削除するPOSTを送信


function removeTweet(tweet_id) {
  var csrf_token = $('meta[name=csrf-token]').attr('content');
  var form = $('<form>', {
    method: 'post',
    action: '/tweet/delete'
  }).append($('<input>', {
    type: 'hidden',
    name: '_token',
    value: csrf_token
  })).append($('<input>', {
    type: 'hidden',
    name: 'tweet_id',
    value: tweet_id
  }));
  form.appendTo(document.body);
  form.submit(); // あとでtarget指定とかした時用
  // form.remove();
}

/***/ }),

/***/ 1:
/*!****************************************!*\
  !*** multi ./resources/js/userpage.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Volumes/Data/MyRoot/Work/就活/ZOZOTechnology/課題/MySNS/resources/js/userpage.js */"./resources/js/userpage.js");


/***/ })

/******/ });