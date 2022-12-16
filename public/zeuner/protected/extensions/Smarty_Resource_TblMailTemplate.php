<?php

class Smarty_Resource_TblMailTemplate extends Smarty_Resource_Custom
{
	/**
	 * Returns the data model based on the primary key given
	 * If the data model is not found, a DB exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TblMailTemplate the loaded model
	 * @throws CDbException
	 */
	protected function loadModel($id)
	{
		$model=TblMailTemplate::model()->findByPk($id);
		if($model===null)
			throw new CDbException('template not found');
		return $model;
	}

	/**
	 * Fetch a template and its modification time from database
	 *
	 * @param string $name template name
	 * @param string $source template source
	 * @param integer $mtime template modification timestamp (epoch)
	 * @return void
	 */
	protected function fetch($name, &$source, &$mtime)
	{
		$model = $this->loadModel(intval($name));
		$source = $model->content;
		$mtime = intval($model->last_change);
	}
 
	/**
	 * Fetch a template's modification time from database
	 *
	 * @note implementing this method is optional. Only implement it if modification times can be accessed faster than loading the comple template source.
	 * @param string $name template name
	 * @return integer timestamp (epoch) the template was modified
	 */
	protected function fetchTimestamp($name) {
		return intval($this->loadModel(intval($name))->last_change);
	}
}
