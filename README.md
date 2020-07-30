# nCore2Transmission

master is v0.8a

future tasks:
- [ ] torrent pages on click
- [ ] response back if download was succesful(everywhere) & show progress on "download started page"
- [ ] ignore download button what is already downloaded and replace with possibility of delete
- [ ] delete possibility depend on hitnrun status


bin/.config file example (this is only you need to do for this project): 
* pauseOnAdd = add torrent as paused or download (true or false)

```
{
	"ncore": {
		"user": "User123",
		"pw": "WordPass",
		"accesskey": "6f2b902e791d7f4b0be902e902e791d4"
	},
	"transmission": {
		"host": "http://127.0.0.1:9091/rpc",
		"user": "admin",
		"pw": "wordpass",
		"download_dir": "/mnt/usb/download",
		"pauseOnAdd": true 
	}
}
```

