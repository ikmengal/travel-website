document.addEventListener("DOMContentLoaded", () => {

    const navbar = document.getElementById("navbar");

    if (!navbar) return;

    const container = navbar.querySelector(".max-w-7xl > div");

    function updateNavbar() {

        if (window.scrollY > 80) {

            container.classList.add(
                "bg-white/95",
                "shadow-2xl",
                "backdrop-blur-xl"
            );

            container.classList.remove(
                "bg-white/90"
            );

        } else {

            container.classList.remove(
                "shadow-2xl"
            );

        }

    }

    updateNavbar();

    window.addEventListener("scroll", updateNavbar);

});
