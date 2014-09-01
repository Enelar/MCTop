

    function render_home_page()
    {
        display_page('social', 'home/index');
        setTimeout(function() {
            render_page_on_tab('social', 'home/home_tab', 'home');
        }, 100);

    }

    function home_main_button()
    {

    }

    function home_news_button()
    {
    }

    function home_updates_button()
    {
    }

    function home_settings_button()
    {
        render_page_on_tab('social', 'misc/edit_profile_info', 'settings');
    }

    function home_help_button()
    {
        render_page_on_tab('main', 'about', 'help');
    }

    function home_blog_button()
    {
        render_page_on_tab('features', 'blog/index', 'blog');
    }

    function home_clubs_button()
    {
        render_page_on_tab('social', 'clubs/index', 'clubs');
    }

    function home_about_button()
    {
        render_page_on_tab('main','about','common');
    }

    function render_page_on_tab(module, action, tab)
    {
        render_page_in_div_by_id(module, action, tab);
    }