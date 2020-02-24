<?php

/**
 * @name   RGDoBak
 * @main   RGDoBak\RGDoBak
 * @author  Regard0606
 * @version  1.0.0
 * @api 3.0.0
 * @description Made By Regard0606
 */

namespace RGDoBak;


use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\command\Command;
use onebone\economyapi\EconomyAPI;

class RGDoBak extends PluginBase implements Listener
{
	public function onEnable ()
	{
		$this->getServer()->getPluginManager()->registerEvents ($this, $this);
		$this->registerCommand('도박','Made by 레가드');
		}
		
	public function registerCommand ($command, $description)
{

     $c = new PluginCommand ($command, $this);
     $c->setDescription ($description);

     $this->getServer()->getCommandMap()->register ($command, $c);
}

public function onCommand (CommandSender $sender, Command $command, string $label, array $args): bool
   {
   if (!isset($args[0])){
	$sender->sendMessage('§l[ §e서버§f ] §r§l§a사용법 : /도박 (금액)');
	$sender->sendMessage('§l[ §e서버§f ] §r§l§a성공하면 금액의 2배를 얻고 실패하면 금액을 잃습니다');
	return true;
	}
    if ($args[0]<=0) {
   $sender->sendMessage('§l[ §e서버§f ] §r§l 0원 이하를 걸 수 없습니다');
	return true;
	}
    if(!is_numeric($args[0])) {
	$sender->sendMessage('§l[ §e서버§f ] §r§l§a금액은 숫자로 입력해주세요');
	return true;
	}
	if (EconomyAPI::getInstance()->myMoney($sender) < $args[0]) {
				$sender->sendMessage('§l[ §e서버§f ] §r§l§a도박할 돈이 부족합니다');
				return true;
			}
	$random = mt_rand(1,2);
    EconomyAPI::getInstance ()->reduceMoney ( $sender, $args[0] );
	if ($random == 1) {
		EconomyAPI::getInstance()->addMoney ( $sender, $args[0]*2);
		$sender->sendMessage('§l[ §e서버§f ] §r§l§a축하합니다. 도박에 성공하셨습니다');
		}
	elseif ($random == 2) {
		$sender->sendMessage('§l[ §e서버§f ] §r§l§a도박에 실패하셨습니다. 한번 더 도전해보세요');
		}
	return true;
		}
		}