<nav>
    <div id="lang">
        <button class="btn btn-subtle">
            <?= $company['Languages']['list'][$language] ?><i class="far fa-angle-down"></i>
        </button>
        <ul>
            <?php
            foreach ($company['Languages']['list'] as $key => $value) {
                ?>
                <li>
                    <a data-language="<?= $key ?>"><?= $value ?></a>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</nav>