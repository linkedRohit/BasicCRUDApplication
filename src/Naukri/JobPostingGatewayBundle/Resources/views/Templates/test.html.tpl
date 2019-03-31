~extends 'file:JobPostingGatewayBundle::layout.html.tpl'`

~title` Jobposting Exception ~/title`

~block name=css_init`
~_ncss`featuredListing~/_ncss`

~/block`

~block name=body`

<div class="errorDiv">
    <div class="alertBox msgBar red" id="alertDiv">
    <div class="errCrs" id="hideAlert"> <p id="errTxt" class="errText">
    <span class="err">Error!</span>
    <p>~$message`</p>
    </div>
    </div>
    <p class="errLink"><a href="asd">Manage</a> your Verified listings </p>
    <p class="errLink lH30"><a href="/nfl/nflReport">View</a> Verified Listings’ Reports </p>
</div>

~/block`