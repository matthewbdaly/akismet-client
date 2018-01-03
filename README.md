# akismet-client

[![Build Status](https://travis-ci.org/matthewbdaly/akismet-client.svg?branch=master)](https://travis-ci.org/matthewbdaly/akismet-client)


A PHP client for the Akismet spam detection service. Built using modern practices and with an extensive test suite.

Installation
------------

Install it with the following command:

```bash
composer require matthewbdaly/akismet-client
```

This library use HTTPlug, so you will also need to install a client implementation [as specified here](http://docs.php-http.org/en/latest/httplug/users.html) in order to actually use this client.

Usage
-----

The client offers the following methds:

* `setKey($key)` - Sets the API key
* `getKey()` - Gets the API key
* `setBlog($blog)` - Sets the blog URL
* `getBlog()` - Gets the blog URL
* `setIp($ip)` - Sets the user IP address
* `getIp()` - Gets the user IP address
* `setAgent($agent)` - Sets the user agent string
* `getAgent()` - Gets the user agent string
* `setReferrer($referrer)` - Sets the referrer URL
* `getReferrer()` - Gets the referrer URL
* `setPermalink($permalink)` - Sets the permalink to the post
* `getPermalink()` - Gets the permalink to the post
* `setCommentType($type)` - Sets the comment type - can be `comment`, `forum-post`, `reply`, `blog-post`, `contact-form`, `signup`, `message` or a custom type
* `getCommentType()` - Gets the comment type
* `setCommentAuthor($author)` - Sets the comment author
* `getCommentAuthor()` - Gets the comment author
* `setCommentAuthorEmail($email)` - Sets the comment author email
* `getCommentAuthorEmail()` - Gets the comment author email
* `setCommentAuthorUrl($url)` - Sets the comment author url
* `getCommentAuthorUrl()` - Gets the comment author url
* `setCommentContent($content)` - Sets the comment content
* `getCommentContent()` - Gets the comment content
* `setCommentDateGMT($date)` - Sets the comment date
* `getCommentDate()` - Gets the comment date
* `setCommentPostModifiedDate($date)` - Sets the comment modified date
* `getCommentPostModifiedDate()` - Gets the comment modified date
* `setBlogLang($lang)` - Sets the blog language
* `getBlogLang()` - Gets the blog language
* `setBlogCharset($charset)` - Sets the blog charset
* `getBlogCharset()` - Gets the blog charset
* `setUserRole($role)` - Sets the user role
* `getUserRole()` - Gets the user role
* `setIsTest($test)` - Sets whether this is a test
* `getIsTest()` - Gets whether this is a test
* `flush()` - Flush all the existing values
* `verifyKey()` - Verify the currently set API key
* `check()` - Check the currently set comment to see if it is spam
* `spam()` - Submit comment to Akisment as spam
* `ham()` - Submit comment to Akisment as ham
* `setParams(array $params)` - Set parameters in bulk
