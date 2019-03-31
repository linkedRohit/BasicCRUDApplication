~extends 'file:NaukriJobPostingGatewayBundle:Reports:layout.html.tpl'`

~block name=title`
    Your Hiring Performance at one place
~/block`
~block name=headlinks`
    <script>
        app = ~$appData|json_encode nofilter`;
    </script>
    ~$ubaSnippet nofilter`
~/block`

~block name=css_init_ore_reports`
~/block`

~block name=body`
    <div id="orereports" class="jpContainer">

    </div>
~/block`
~block name=js_init_ore_reports`
~/block`
