= Auto Fee Optimizer

This is an automatic fee optimizer for lnd. It's meant to be minimal in configuration, as it will attempt to discover the best fees for each channel based on historical flow and balance.


== Install, setup, and run


```
$ git clone https://github.com/thorie7912/auto-fee-optimizer
$ cd auto-fee-optimizer
$ composer update
$ cp config.php-example config.php
```

Edit the `config.php` file. Set the values according to your system and preferences.


```
$ ./optimized &
$ tail -f debug.log
```

The optimizer runs in the background. You can interact with it using `optimize-cli` which will give you options to view or alter it's behavior. You can use tools such as supervisord to make it a process that always runs in the background on your system if you prefer.

The optimizer will not make any fee changes automatically if you set the `auto` to `false`. It will put all changes in a queue for you to manually accept or reject via the `optimize-cli` tool. This is primarily useful for debugging or testing the app.


