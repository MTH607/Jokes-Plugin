    <h1>Jokes Plugin</h1>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php
        settings_fields('joke_options_group');
        do_settings_sections('jokes_plugin');
        submit_button();
        ?>
    </form>