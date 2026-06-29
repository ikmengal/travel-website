// import gsap from "gsap";
// import { ScrollTrigger } from "gsap/ScrollTrigger";

// gsap.registerPlugin(ScrollTrigger);

// // Animations baad me add karenge


// import gsap from "gsap";

// document.addEventListener("DOMContentLoaded", () => {

//     gsap.from(".hero-title", {
//         y: 80,
//         opacity: 0,
//         duration: 1,
//         ease: "power4.out"
//     });

//     gsap.from(".hero-text", {
//         y: 40,
//         opacity: 0,
//         duration: 1,
//         delay: 0.3
//     });

//     gsap.from(".hero-buttons", {
//         y: 30,
//         opacity: 0,
//         duration: 1,
//         delay: 0.6
//     });

// });


import gsap from "gsap";

document.addEventListener("DOMContentLoaded", () => {

    gsap.from(".hero-title", {
        y: 80,
        opacity: 0,
        duration: 1.2,
        ease: "power4.out"
    });

    gsap.from(".hero-text", {
        y: 50,
        opacity: 0,
        delay: .3,
        duration: 1
    });

    gsap.from(".hero-buttons", {
        y: 40,
        opacity: 0,
        delay: .6,
        duration: 1
    });

});
