module.exports = {
  Employee: {
    new_employee_button: '#page-header-desc-configuration-add',
    first_name_input: '#employee_firstname',
    last_name_input: '#employee_lastname',
    email_input: '#employee_email',
    password_input: '#employee_password',
    profile_select: '#employee_profile',
    save_button: '.card-footer button',
    orders_page: '//*[@id="subtab-AdminParentOrders"]/a',
    email_search_input: '#employee_email',
    search_button_team: '//button[@name="employee[actions][search]"]',
    search_result: '//h3[contains(@class,"card-header-title")]',
    team_employee_name: '//*[@id="employee_grid_table"]//tbody//td[3]',
    team_employee_last_name: '//*[@id="employee_grid_table"]//tbody//td[4]',
    team_employee_email: '//*[@id="employee_grid_table"]//tbody//td[5]',
    team_employee_profile: '//*[@id="employee_grid_table"]//tbody//td[6]',
    reset_search_button: '//button[@name="employee[actions][reset]"]',
    dropdown_toggle: '//*[@id="employee_grid_table"]//tbody//a[@data-toggle="dropdown"]',
    delete_link: '//*[@id="employee_grid_table"]//tbody//a/i[text()="delete"]',
    edit_button: '//*[@id="employee_grid_table"]//a[contains(@class, "edit")]',
    language_select: '//*[@id="id_lang"]',
    selected_language_option: '//*[@id="id_lang"]/option[@selected="selected"]',
    employee_column_information: '//*[@id="employee_grid_table"]//tr[1]/td[%COL]',
    success_panel: '//*[@id="content"]/div[@class="bootstrap"]/div[contains(@class, "success")] | //div[contains(@class,"alert-success")]//*[contains(@class,"alert-text")]//p',
  }
};