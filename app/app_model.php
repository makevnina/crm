<?php
class AppModel extends Model {

 /**
	 * Process INSERT-query on several rows of data
	 *
	 * Data examples:
	 *   - single row insert:
	 *     $data = {
	 *       'fieldName1' : 'Value5',
	 *       'fieldName2' : 'Value6'
	 *     }
	 *   - several rows insert:
	 *     $data = [
	 *       {
	 *         'fieldName1' : 'Value1',
	 *         'fieldName2' : 'Value2'
	 *       },
	 *       {
	 *         'fieldName1' : 'Value3',
	 *         'fieldName2' : 'Value4'
	 *       },
	 *     ]
	 *   - select format - see DataSource::buildStatement method
	 *
	 *
	 * Available options:
	 *   $options = {
	 *     'fields' : array,   // Fields list with or without defaults
	 *                         // See examples below
	 *     'table'  : string,  // Table name, if empty then $this->table
	 *                         // is using
	 *     'ignore' : boolean, // Ignore duplicate key rows on insert
	 *                         // default - false
	 *     'update' : array,   // Update duplicate key rows
	 *                         // See examples below
	 *     'as_is'  : array    // Skip value escaping for listed fields
	 *                         // [fieldName1, fieldName2]
	 *                         // or for all fields if boolean true
	 *     'select' : boolean  // On True the $data array will be interpreted
	 *                         // as select statement in Model::find format
	 *                         // to make INSERT ... SELECT queries
	 *   }
	 *
	 * Option 'fields' examples:
	 *   - with default values
	 *     $options = {
	 *       'fields' : {
	 *         'fieldName1' : 'defaultValue',
	 *         'fieldName2' : null,
	 *         'fieldName3' : 12345,
	 *       }
	 *     }
	 *   - without default values or for use in INSERT ... SELECT query
	 *     $options = {
	 *       'fields' : [
	 *         'fieldName1',  // All default values will be NULL
	 *         'fieldName2',
	 *         'fieldName3',
	 *       ]
	 *     }
	 *
	 * Option 'update' examples:
	 *   - Full form:
	 *     $options = {
	 *       'update' : {
	 *         'field1' : 'VALUES(field1)', // Replace existing value by new one
	 *         'field2' : 'field2 + 1',     // Calculate new value in
	 *                                      // SQL statement
	 *       }
	 *     }
	 *   - Short form:
	 *     $options = {
	 *       'update' : [
	 *         'field1',  // Replace all existing values by new ones
	 *         'field2',
	 *         'field3',
	 *       ]
	 *     }
	 *   - Very short form #1:
	 *     $options = {
	 *       'update' : 'field1', // Same as short form, but for one field
	 *     }
	 *   - Very short form #2:
	 *     $options = {
	 *       'update' : true, // Same as short form, but for all fields
	 *     }
	 *
	 * @param  array $data    Data to insert
	 * @param  array $options Insert options
	 * @return boolean
	 */
	public function insert($data, $options = array ()) {
		$DS = $this->getDataSource();

		// INSERT ... SELECT query
		if (gp($options, 'select')) {
			$statement = array_merge(
				array(
					'fields' => array(),
					'table' => $this->table,
					'alias' => null,
					'limit' => null,
					'offset' => null,
					'joins' => array(),
					'conditions' => null,
					'order' => null,
					'group' => null
				),
				$data
			);
			if (! $statement['alias']) {
				$statement['alias'] = $statement['table'];
			}

			$values = $DS->buildStatement($statement, $this);
			$names = gp($options, 'fields');
			if (! $names) {
				foreach ($statement['fields'] as $field) {
					if (strpos($field, '.')) {
						$field = str_replace($statement['alias'], '', $field);
					}
					$names[] = $field;
				}
			}
		}
		// INSERT ... VALUES query
		else {
			// Formatting parameters
			if (is_assoc($data)) {
				$data = array ($data);
			}

			$fields = gp($options, 'fields');
			if (! $fields) {
				$fields = array_keys(reset($data));
			}
			if (! is_assoc($fields)) {
				$fields = array_fill_keys($fields, null);
			}
			$names = array_keys($fields);
			$as_is = (array) gp($options, 'as_is', array ());

			// Escaping values
			$values = array ();
			foreach ($data as $row) {
				$rowValues = array ();
				foreach ($fields as $field => $defaultValue) {
					$value = gp($row, $field, $defaultValue);
					if ($as_is === true || in_array($field, $as_is)) {
						$rowValues[] = $value;
					}
					else {
						$rowValues[] = $DS->value($value);
					}
				}
				$values[] = '('.implode(', ', $rowValues).')';
			}
			$values = 'VALUES '.implode(', ', $values);
		}

		// Escaping field names
		foreach ($names as &$field) {
			$field = $DS->name($field);
		}
		unset($field);
		$names = implode(', ', $names);

		// Constructing and executing query
		$ignore = gp($options, 'ignore') ? 'IGNORE' : '';
		$table = gp($options, 'table', $this->table);
		$queryText =
			"INSERT {$ignore} INTO {$table} ({$names}) {$values}";

		if ($update = gp($options, 'update')) {
			if ($update === true) {
				$update = array_keys($fields);
			}
			$update = (array) $update;
			if (! is_assoc($update)) {
				$update = array_fill_keys($update, null);
				foreach ($update as $name => &$statement) {
					$statement = 'VALUES('.$DS->name($name).')';
				}
				unset($statement);
			}
			foreach ($update as $name => &$statement) {
				$statement = $DS->name($name).' = '.$statement;
			}
			unset($statement);
			$queryText .= ' ON DUPLICATE KEY UPDATE '.implode(', ', $update);
		}

		$this->query($queryText);
		$this->setInsertID($DS->lastInsertID());

		// Return execute status
		return !$DS->error;
	}

}