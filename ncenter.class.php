<?php
class ncenter extends ModuleObject
{
	private $triggers = array(
		array('comment.insertComment',     'ncenter', 'controller', 'triggerAfterInsertComment',            'after'),
		array('comment.deleteComment',     'ncenter', 'controller', 'triggerAfterDeleteComment',            'after'),
		array('document.insertDocument',   'ncenter', 'controller', 'triggerAfterInsertDocument',           'after'),
		array('document.deleteDocument',   'ncenter', 'controller', 'triggerAfterDeleteDocument',           'after'),
		array('document.updateVotedCount', 'ncenter', 'controller', 'triggerAfterDocumentUpdateVotedCount', 'after'),
		array('display',                   'ncenter', 'controller', 'triggerBeforeDisplay',                 'before'),
		array('moduleHandler.proc',        'ncenter', 'controller', 'triggerAfterModuleHandlerProc',        'after'),
		array('moduleObject.proc',         'ncenter', 'controller', 'triggerBeforeModuleObjectProc',        'before'),
		array('member.deleteMember',       'ncenter', 'controller', 'triggerAfterDeleteMember',             'after')
	);

	function moduleInstall()
	{
		$oModuleModel = getModel('module');
		$oModuleController = getController('module');

		foreach($this->triggers as $trigger)
		{
			if(!$oModuleModel->getTrigger($trigger[0], $trigger[1], $trigger[2], $trigger[3], $trigger[4]))
			{
				$oModuleController->insertTrigger($trigger[0], $trigger[1], $trigger[2], $trigger[3], $trigger[4]);
			}
		}

		return new Object();
	}

	function checkUpdate()
	{
		$oModuleModel = getModel('module');

		foreach($this->triggers as $trigger)
		{
			if(!$oModuleModel->getTrigger($trigger[0], $trigger[1], $trigger[2], $trigger[3], $trigger[4])) return true;
		}

		return false;
	}

	function moduleUpdate()
	{
		$oModuleModel = getModel('module');
		$oModuleController = getController('module');

		foreach($this->triggers as $trigger)
		{
			if(!$oModuleModel->getTrigger($trigger[0], $trigger[1], $trigger[2], $trigger[3], $trigger[4]))
			{
				$oModuleController->insertTrigger($trigger[0], $trigger[1], $trigger[2], $trigger[3], $trigger[4]);
			}
		}

		return new Object(0, 'success_updated');
	}

	function moduleUninstall()
	{
		$oModuleController = getController('module');

		foreach($this->triggers as $trigger)
		{
			$oModuleController->deleteTrigger($trigger[0], $trigger[1], $trigger[2], $trigger[3], $trigger[4]);
		}

		return new Object();
	}

	function recompileCache()
	{
	}
}
