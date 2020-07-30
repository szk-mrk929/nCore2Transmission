# nCore2Transmission
future tasks:
- [ ] response back if download was succesful
- [ ] ignore button what is already downloaded
- [ ] hitnrun status
- [ ] show torrent statuses also on search list


bin/.config file example: 

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