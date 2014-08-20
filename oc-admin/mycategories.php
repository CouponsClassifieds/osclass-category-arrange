  
<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

    /*
     *      Osclass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2012 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */




    class CAdminCategories extends AdminSecBaseModel
    {
        //specific for this class
        private $categoryManager;

        function __construct()
        {
            parent::__construct();

            //specific things for this class
            $this->categoryManager = Category::newInstance();
        }

        //Business Layer...
        function doModel()
        {
            parent::doModel();

            //specific things for this class
            switch ($this->action)
            {
                case('add_post_default'): // add default category and reorder parent categories
                                        osc_csrf_check();
                                        $fields['fk_i_parent_id'] = NULL;
                                        $fields['i_expiration_days'] = 0;
                                        $fields['i_position'] = 0;
                                        $fields['b_enabled'] = 1;
                                        $fields['b_price_enabled'] = 1;

                                        $default_locale = osc_language();
                                        $aFieldsDescription[$default_locale]['s_name'] = "NEW CATEGORY, EDIT ME!";

                                        $categoryId = $this->categoryManager->insert($fields, $aFieldsDescription);

                                        // reorder parent categories. NEW category first
                                        $rootCategories = $this->categoryManager->findRootCategories();
                                        foreach($rootCategories as $cat){
                                            $order = $cat['i_position'];
                                            $order++;
                                            $this->categoryManager->updateOrder($cat['pk_i_id'],$order);
                                        }
                                        $this->categoryManager->updateOrder($categoryId,'0');

                                        $this->redirectTo(osc_admin_base_url(true).'?page=mycategories');
                break;
                default:                //
                                        $this->_exportVariableToView("categories", $this->categoryManager->toTreeAll() );
                                        $this->doView("mycategories/index.php");

            }
        }

        //hopefully generic...
        function doView($file)
        {
            osc_run_hook("before_admin_html");
            osc_current_admin_theme_path($file);
            Session::newInstance()->_clearVariables();
            osc_run_hook("after_admin_html");
           echo "<h1 class='tit'>Drag 5 items per row only, if there are 6 move to next row</h1>";

        }
    }

    /* file end: ./oc-admin/categories.php */
?>
<style type="text/css">.actions-cat{display: none}.sortable{list-style-type: none; margin: 0; padding: 0;}.sortable li { margin: 3px 3px 3px 0; padding: 1px;  font-size: 2em; text-align: left;  }.ico-childrens{display: none;}.list-categories .name-cat, .list-fields .name-edit-cfield{font-size: 10px;padding: 0;margin: 0;}.list-categories .category_row{padding-left:40px!important; } 
.list-categories .name-cat, .list-fields .name-edit-cfield{padding-right: 5px!important;}
#content-head h1, #content-head h2{display: none;}
h1.tit{position: absolute;
top: 50;
left: 120px;
font-size: 25px;
color: red;
border-bottom: 2px dashed #fff;
line-height: 50px;}
</style>
  

