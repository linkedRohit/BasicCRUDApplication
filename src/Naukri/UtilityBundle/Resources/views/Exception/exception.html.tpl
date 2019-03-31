<div class="sf-exceptionreset">

    <div class="block_exception">
        <div class="block_exception_detected clear_fix">
            <div class="illustration_exception">
                <img alt="Exception detected!" src="{asset}bundles/framework/images/exception_detected.png{/asset}"/>
            </div>
            <div class="text_exception">

                <div class="open_quote">
                    <img alt="" src="{asset}bundles/framework/images/open_quote.gif{/asset}"/>
                </div>

                <h1>
                    ~$exception->getMessage()`
                </h1>

                <div>
                    <strong>~$status_code`</strong> ~$status_text` - ~$exception->getClass()`
                </div>
                ~assign var="previous_count" value=count($exception->getAllPrevious())`
                ~if $previous_count`
                    <div class="linked"><span><strong>~$previous_count`</strong> linked Exception</span>
                        <ul>
                            ~foreach from=$exception->getAllPrevious() key=idx item=previous`
                                <li>
                                    ~$previous->getClass()` <a href="#traces_link_~$idx + 1 `" onclick="toggle('traces_~$idx + 1 `', 'traces'); switchIcons('icon_traces_~$idx + 1 `_open', 'icon_traces_~$idx + 1 `_close');">&#187;</a>
                                </li>
                            ~/foreach`
                        </ul>
                    </div>
                ~/if`
                <div class="close_quote">
                    <img alt="" src="{asset}bundles/framework/images/close_quote.gif{/asset}"/>
                </div>

            </div>
        </div>
    </div>
    ~foreach from=$exception->getTrace() key=idx item=e`
        <div>
            ~$idx + 1`.&nbsp;
            ~if $e.function`
                at <b>~$e.short_class`~$e.type`~$e.function`</b>
                (~$e.args`)
            ~/if`
            ~if array_key_exists('file', $e) && $e.file && array_key_exists('line', $e) && $e.line`
                ~if $e.function`
                    <br />
                ~/if`
                in ~$e.file`&nbsp;line ~$e.line`
            ~/if`
        </div>
    ~/foreach`
</div>

<script type="text/javascript">//<![CDATA[
    function toggle(id, clazz) {
        var el = document.getElementById(id),
            current = el.style.display,
            i;

        if (clazz) {
            var tags = document.getElementsByTagName('*');
            for (i = tags.length - 1; i >= 0 ; i--) {
                if (tags[i].className === clazz) {
                    tags[i].style.display = 'none';
                }
            }
        }

        el.style.display = current === 'none' ? 'block' : 'none';
    }

    function switchIcons(id1, id2) {
        var icon1, icon2, visibility1, visibility2;

        icon1 = document.getElementById(id1);
        icon2 = document.getElementById(id2);

        visibility1 = icon1.style.visibility;
        visibility2 = icon2.style.visibility;

        icon1.style.visibility = visibility2;
        icon2.style.visibility = visibility1;
    }
//]]></script>
