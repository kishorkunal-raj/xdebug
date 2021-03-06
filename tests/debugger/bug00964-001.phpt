--TEST--
Test for bug #964: IP retrival from X-Forwarded-For complies with RFC 7239 (without comma)
--SKIPIF--
<?php
require __DIR__ . '/../utils.inc';
check_reqs('!win; unparallel');
?>
--ENV--
HTTP_X_FORWARDED_FOR=192.168.111.111
--INI--
xdebug.mode=debug
xdebug.start_with_request=yes
xdebug.log={TMPDIR}/bug964.txt
xdebug.remote_connect_back=1
xdebug.remote_port=9003
--FILE--
<?php
preg_match(
	"#Remote address found, connecting to ([^:]+):9003#",
	file_get_contents( sys_get_temp_dir() . "/bug964.txt" ),
	$match
);
unlink( sys_get_temp_dir() . "/bug964.txt" );
echo $match[1];
?>
--EXPECTF--
Xdebug: [Step Debug] Could not connect to debugging client. Tried: 192.168.111.111:9003 (from HTTP_X_FORWARDED_FOR HTTP header), localhost:9003 (fallback through xdebug.remote_host/xdebug.remote_port) :-(
192.168.111.111
