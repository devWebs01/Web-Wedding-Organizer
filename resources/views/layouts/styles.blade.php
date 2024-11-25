<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Reddit+Sans:ital,wght@0,200..900;1,200..900&display=swap');

    * {
        font-family: "Reddit Sans", sans-serif;
        font-optical-sizing: auto;
        /* font-weight: <weight>;
        font-style: normal; */
    }

    .pagination {
        justify-content: center;
        --bs-pagination-active-bg: #000000;
        --bs-pagination-color: black;
    }

    .active>.page-link,
    .page-link.active {
        border-color: #000000;
    }

    .nav-pills .nav-link {
        color: black;
    }

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        color: white;
        background-color: black;
    }

    #font-custom {
        font-family: "DM Serif Display", serif;
        font-weight: 400;
        font-style: normal;
    }

    .font-stroke {
        text-shadow: 2px 2px #646262;
    }

    .btn-custom {
        padding: 12px 24px;
        background-color: white;
        border-radius: 6px;
        position: relative;
        overflow: hidden;
    }

    .btn-custom span {
        color: black;
        position: relative;
        z-index: 1;
        transition: color 0.6s cubic-bezier(0.53, 0.21, 0, 1);
    }

    .btn-custom::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        border-radius: 6px;
        transform: translate(-100%, -50%);
        width: 100%;
        height: 100%;
        background-color: hsl(244, 63%, 69%);
        transition: transform 0.6s cubic-bezier(0.53, 0.21, 0, 1);
    }

    .btn-custom:hover span {
        color: white;
    }

    .btn-custom:hover::before {
        transform: translate(0, -50%);
    }

    .text-custom {
        color: #f35525;
    }

    .tooltip-text {
        position: absolute;
        top: -110px;
        left: -100%;
        */ z-index: 3;
        width: 150px;
        color: white;
        font-size: 12px;
        background-color: #192733;
        border-radius: 10px;
        padding: 20px 5px 20px 5px;
    }

    #fade {
        opacity: 0;
        transition: opacity 0.5s;
    }

    .hover-text:hover #fade {
        opacity: 1;
    }

    .hover-text {
        position: relative;
        display: inline-block;
        /* margin: 40px; */
        /* font-family: Arial; */
        text-align: center;
    }

    .hover {
        --c: #9c9259;
        /* the color */

        color: #0000;
        background:
            linear-gradient(90deg, #fff 50%, var(--c) 0) calc(100% - var(--_p, 0%))/200% 100%,
            linear-gradient(var(--c) 0 0) 0% 100%/var(--_p, 0%) 100% no-repeat;
        -webkit-background-clip: text, padding-box;
        background-clip: text, padding-box;
        transition: 0.5s;
        border-radius: 10px;
    }

    .hover:hover {
        --_p: 100%
    }

    #close {
        position: absolute;
        right: -30px;
        top: 0;
        z-index: 999;
        --bs-btn-close-color: white;
    }

    .bg-custom-secondary {
        background-color: #f35525;
    }
</style>
