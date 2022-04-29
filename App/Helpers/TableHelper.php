<?php

namespace App\Helpers;

/**
 * The class that contains helper methods for HTML tables.
 */
final class TableHelper
{
	/**
	 * Builds a table header.
	 * 
	 * @param array $cols The column names for the header.
	 * @return string The completed header.
	 */
	public static final function buildTableHead(array $cols): string
	{
        $header_columns = '';
        foreach ($cols as $col)
            $header_columns .= "<th scope='col'>$col</th>";

		return  "
				<thead>
                    <tr>
                        $header_columns
                    </tr>
                </thead>
				";
	}
}