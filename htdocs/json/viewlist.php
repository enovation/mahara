<?php
/**
 *
 * @package    mahara
 * @subpackage core
 * @author     Catalyst IT Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL version 3 or later
 * @copyright  For copyright information on Mahara, please see the README file distributed with this software.
 *
 */

define('INTERNAL', 1);
define('JSON', 1);

require(dirname(dirname(__FILE__)) . '/init.php');
require_once(get_config('libroot') . 'view.php');
require_once('pieforms/pieform.php');

$offset = param_integer('offset', 0);
$limit = param_integer('limit', 0);
$setlimit = param_boolean('setlimit', false);

list($searchform, $data, $pagination) = View::views_by_owner();

$smarty = smarty_core();
$smarty->assign('views', $data->data);
$smarty->assign('querystring', get_querystring());
$html = $smarty->fetch('view/indexresults.tpl');

json_reply(false, array(
    'message' => null,
    'data' => array(
        'tablerows' => $html,
        'pagination' => $pagination['html'],
        'pagination_js' => $pagination['javascript'],
        'count' => $data->count,
        'results' => $data->count . ' ' . ($data->count == 1 ? get_string('result') : get_string('results')),
        'offset' => $offset,
        'query' => (param_variable('query', null)),
        'setlimit' => $setlimit,
    )
));