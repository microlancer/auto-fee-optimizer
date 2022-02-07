<?php

namespace AFO;

class Optimizer
{
  public function __construct()
  {

  }

public function runDaemon()
{
	while (true) {

    sleep(1);
    echo date("Y-m-d H:i:s\n");

  }
}

	public function runCli()
  {
    echo "Auto fee optimizer (AFO) for LND v0.1.0-beta\n";
  }
}
