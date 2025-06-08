function loadTab(name) {
    $activeElem = document.getElementById("moderation-actions").getElementsByClassName("activeButton")
    if ($activeElem.length > 0) {
        $activeElem[0].classList.remove("activeButton");
    }
    document.getElementById(`moderation-${name}`).classList.add("activeButton");
    fetch(`/moderation.php?tab=${name}`)
        .then(response => response.text())
        .then(html => document.getElementById("moderation-container").innerHTML = html);
}