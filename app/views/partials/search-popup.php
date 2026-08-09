<div class="search-popup">
    <button class="close-search" aria-label="close search" title="Close"><i class="fa-solid fa-xmark"></i></button>
    <form action="<?= e(url('search')) ?>" method="get" role="search">
        <div class="search-popup__group">
            <input type="search" name="q" id="searchField" placeholder="Search the site…" required
                   value="<?= e(get('q')) ?>" aria-label="Search">
            <button type="submit" aria-label="search" title="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </form>
</div>
