<?php
/**
 * FileBasedPersistentModel class file.
 *
 * @author Isidor Zeuner <yii@quidecco.de>
 * @link http://quidecco.de/
 * @copyright 2016 Isidor Zeuner
 * @license http://www.yiiframework.com/license/
 */

abstract class FileBasedPersistentModel extends GenericPersistentModel
{
	private $directory;
	private $basename;
	/**
	 * Constructor.
	 * @param string $directory directory where the model data is stored
	 * @param string $basename filename under which the model data is stored in the directory
	 * @param string $scenario scenario name. See {@link CModel::scenario} for more details about this parameter.
	 * Note: in order to setup initial model parameters use {@link init()} or {@link afterConstruct()}.
	 * Do NOT override the constructor unless it is absolutely necessary!
	 */
	public function __construct(
		$directory,
		$basename,
		$scenario='insert'
	) {
		$this->directory = $directory;
		$this->basename = $basename;
		parent::__construct(
			$scenario
		);
	}

	protected function set_by_string(
		$data
	) {
		$new_version = tempnam(
			$this->directory,
			$this->basename
		);
		$handle = fopen(
			$new_version,
			"w"
		);
		if (
			FALSE === $handle
		) {
			throw new CException(
				'Could not open file for new model data'
			);
		}
		if (
			FALSE === fputs(
				$handle,
				$data
			)
		) {
			throw new CException(
				'Could not write new model data'
			);
		}
		if (
			FALSE === fclose(
				$handle
			)
		) {
			throw new CException(
				'Could not close file for new model data'
			);
		}
		if (
			!rename(
				$new_version,
				$this->directory . '/' . $this->basename
			)
		) {
			throw new CException(
				'Could not replace old model data'
			);
		}
	}

	protected function set_by_file(
		$filename
	) {
		$new_version = tempnam(
			$this->directory,
			$this->basename
		);
		if (
			!copy(
				$filename,
				$new_version
			)
		) {
			throw new CException(
				'Could not write new model data'
			);
		}
		if (
			!rename(
				$new_version,
				$this->directory . '/' . $this->basename
			)
		) {
			throw new CException(
				'Could not replace old model data'
			);
		}
	}

	protected function get_data(
	) {
		return require(
			$this->directory . '/' . $this->basename
		);
	}
}
