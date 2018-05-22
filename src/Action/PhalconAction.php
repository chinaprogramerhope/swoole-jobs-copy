<?php
namespace Kcloze\Jobs\Action;
use Kcloze\Jobs\Config;
use Kcloze\Jobs\JobObject;
use Kcloze\Jobs\Logs;
use Kcloze\Jobs\Utils;
use Phalcon\Cli\Console as ConsoleApp;

class PhalconAction {
		public function init() {
				$this->logger = Logs::getLogger(Config::getConfig()['logPath'] ?? '', Config::getConfig()['logSaveFileApp'] ?? '', Config::getConfig()['system'] ?? '');
		}

		public function start() {
				$this->init();
				try {
						$argument['task'] = $JobObject->jobClass;
						$argument['action'] = $JobObject->jobMethod;
						$argument['params'] = $JobObject->jobParams;

						$config = include SWOOLE_JOBS_ROOT_PATH . '/../ycf_config/' . YII_ENV_APP_NAME . '/config.php';
						include SWOOLE_JOBS_ROOT_PATH . '/app/config/loader.php';
						include SWOOLE_JOBS_ROOT_PATH . '/app/config/mainCli.php';

						$console = new ConsoleApp($di);
						$console->handle($arguments);
						$console->logger->flush();
				} catch (\Throwable $e) {
						Utils::catchError($this->logger, $e);
				} catch (\Exception $e) {
						Utils::catchError($this->logger, $e);
				}
		}
}
