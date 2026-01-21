<style>
    .form-container {
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .personal-information {
        background-color: #3C8DC5;
        color: #fff;
        padding: 1px 0;
        text-align: center;
    }

    .column-left {
        width: 49% !important;
        float: left;
        margin-bottom: 2px;
    }

    .column-right {
        width: 49% !important;
        float: right;
    }

    .form-container .frows-in input {
        border: none !important;
        border-radius: 5px;
        height: 52px;
        font-size: 16px;
        background-color: #dde8f0 !important;
        width: 100% !important;
        border-bottom: 0px !important;
    }

    .mb-1 {
        margin-bottom: 0.5rem !important;
    }

    .mt-1 {
        margin-top: 0.5rem !important;
    }

    .authrize {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
</style>
<style type="text/css">
    .jp-card.jp-card-safari.jp-card-identified .jp-card-front:before,
    .jp-card.jp-card-safari.jp-card-identified .jp-card-back:before {
        background-image: repeating-linear-gradient(45deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-linear-gradient(135deg, rgba(255, 255, 255, 0.05) 1px, rgba(255, 255, 255, 0) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.03) 4px), repeating-linear-gradient(90deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-linear-gradient(210deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), -webkit-linear-gradient(-245deg, rgba(255, 255, 255, 0) 50%, rgba(255, 255, 255, 0.2) 70%, rgba(255, 255, 255, 0) 90%);
        background-image: repeating-linear-gradient(45deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-linear-gradient(135deg, rgba(255, 255, 255, 0.05) 1px, rgba(255, 255, 255, 0) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.03) 4px), repeating-linear-gradient(90deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-linear-gradient(210deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), linear-gradient(-25deg, rgba(255, 255, 255, 0) 50%, rgba(255, 255, 255, 0.2) 70%, rgba(255, 255, 255, 0) 90%);
    }

    .jp-card.jp-card-ie-10.jp-card-flipped,
    .jp-card.jp-card-ie-11.jp-card-flipped {
        -webkit-transform: 0deg;
        -moz-transform: 0deg;
        -ms-transform: 0deg;
        -o-transform: 0deg;
        transform: 0deg;
    }

    .jp-card.jp-card-ie-10.jp-card-flipped .jp-card-front,
    .jp-card.jp-card-ie-11.jp-card-flipped .jp-card-front {
        -webkit-transform: rotateY(0deg);
        -moz-transform: rotateY(0deg);
        -ms-transform: rotateY(0deg);
        -o-transform: rotateY(0deg);
        transform: rotateY(0deg);
    }

    .jp-card.jp-card-ie-10.jp-card-flipped .jp-card-back,
    .jp-card.jp-card-ie-11.jp-card-flipped .jp-card-back {
        -webkit-transform: rotateY(0deg);
        -moz-transform: rotateY(0deg);
        -ms-transform: rotateY(0deg);
        -o-transform: rotateY(0deg);
        transform: rotateY(0deg);
    }

    .jp-card.jp-card-ie-10.jp-card-flipped .jp-card-back:after,
    .jp-card.jp-card-ie-11.jp-card-flipped .jp-card-back:after {
        left: 18%;
    }

    .jp-card.jp-card-ie-10.jp-card-flipped .jp-card-back .jp-card-cvc,
    .jp-card.jp-card-ie-11.jp-card-flipped .jp-card-back .jp-card-cvc {
        -webkit-transform: rotateY(180deg);
        -moz-transform: rotateY(180deg);
        -ms-transform: rotateY(180deg);
        -o-transform: rotateY(180deg);
        transform: rotateY(180deg);
        left: 5%;
    }

    .jp-card.jp-card-ie-10.jp-card-flipped .jp-card-back .jp-card-shiny,
    .jp-card.jp-card-ie-11.jp-card-flipped .jp-card-back .jp-card-shiny {
        left: 84%;
    }

    .jp-card.jp-card-ie-10.jp-card-flipped .jp-card-back .jp-card-shiny:after,
    .jp-card.jp-card-ie-11.jp-card-flipped .jp-card-back .jp-card-shiny:after {
        left: -480%;
        -webkit-transform: rotateY(180deg);
        -moz-transform: rotateY(180deg);
        -ms-transform: rotateY(180deg);
        -o-transform: rotateY(180deg);
        transform: rotateY(180deg);
    }

    .jp-card.jp-card-ie-10.jp-card-amex .jp-card-back,
    .jp-card.jp-card-ie-11.jp-card-amex .jp-card-back {
        display: none;
    }

    .jp-card-logo {
        height: 36px;
        width: 60px;
        font-style: italic;
    }

    .jp-card-logo,
    .jp-card-logo:before,
    .jp-card-logo:after {
        box-sizing: border-box;
    }

    .jp-card-logo.jp-card-amex {
        text-transform: uppercase;
        font-size: 4px;
        font-weight: bold;
        color: white;
        background-image: repeating-radial-gradient(circle at center, #FFF 1px, #999 2px);
        background-image: repeating-radial-gradient(circle at center, #FFF 1px, #999 2px);
        border: 1px solid #EEE;
    }

    .jp-card-logo.jp-card-amex:before,
    .jp-card-logo.jp-card-amex:after {
        width: 28px;
        display: block;
        position: absolute;
        left: 16px;
    }

    .jp-card-logo.jp-card-amex:before {
        height: 28px;
        content: "american";
        top: 3px;
        text-align: left;
        padding-left: 2px;
        padding-top: 11px;
        background: #267AC3;
    }

    .jp-card-logo.jp-card-amex:after {
        content: "express";
        bottom: 11px;
        text-align: right;
        padding-right: 2px;
    }

    .jp-card.jp-card-amex.jp-card-flipped {
        -webkit-transform: none;
        -moz-transform: none;
        -ms-transform: none;
        -o-transform: none;
        transform: none;
    }

    .jp-card.jp-card-amex.jp-card-identified .jp-card-front:before,
    .jp-card.jp-card-amex.jp-card-identified .jp-card-back:before {
        background-color: #108168;
    }

    .jp-card.jp-card-amex.jp-card-identified .jp-card-front .jp-card-logo.jp-card-amex {
        opacity: 1;
    }

    .jp-card.jp-card-amex.jp-card-identified .jp-card-front .jp-card-cvc {
        visibility: visible;
    }

    .jp-card.jp-card-amex.jp-card-identified .jp-card-front:after {
        opacity: 1;
    }

    .jp-card-logo.jp-card-discover {
        background: #FF6600;
        color: #111;
        text-transform: uppercase;
        font-style: normal;
        font-weight: bold;
        font-size: 10px;
        text-align: center;
        overflow: hidden;
        z-index: 1;
        padding-top: 9px;
        letter-spacing: .03em;
        border: 1px solid #EEE;
    }

    .jp-card-logo.jp-card-discover:before,
    .jp-card-logo.jp-card-discover:after {
        content: " ";
        display: block;
        position: absolute;
    }

    .jp-card-logo.jp-card-discover:before {
        background: white;
        width: 200px;
        height: 200px;
        border-radius: 200px;
        bottom: -5%;
        right: -80%;
        z-index: -1;
    }

    .jp-card-logo.jp-card-discover:after {
        width: 8px;
        height: 8px;
        border-radius: 4px;
        top: 10px;
        left: 27px;
        background-color: #FF6600;
        background-image: -webkit-radial-gradient(#FF6600, #fff, , , , , , , , );
        background-image: radial-gradient(#FF6600, #fff, , , , , , , , );
        content: "network";
        font-size: 4px;
        line-height: 24px;
        text-indent: -7px;
    }

    .jp-card .jp-card-front .jp-card-logo.jp-card-discover {
        right: 12%;
        top: 18%;
    }

    .jp-card.jp-card-discover.jp-card-identified .jp-card-front:before,
    .jp-card.jp-card-discover.jp-card-identified .jp-card-back:before {
        background-color: #86B8CF;
    }

    .jp-card.jp-card-discover.jp-card-identified .jp-card-logo.jp-card-discover {
        opacity: 1;
    }

    .jp-card.jp-card-discover.jp-card-identified .jp-card-front:after {
        -webkit-transition: 400ms;
        -moz-transition: 400ms;
        transition: 400ms;
        content: " ";
        display: block;
        background-color: #FF6600;
        background-image: -webkit-linear-gradient(#FF6600, #ffa366, #FF6600);
        background-image: linear-gradient(#FF6600, #ffa366, #FF6600, , , , , , , );
        height: 50px;
        width: 50px;
        border-radius: 25px;
        position: absolute;
        left: 100%;
        top: 15%;
        margin-left: -25px;
        box-shadow: inset 1px 1px 3px 1px rgba(0, 0, 0, 0.5);
    }

    .jp-card-logo.jp-card-visa {
        background: white;
        text-transform: uppercase;
        color: #1A1876;
        text-align: center;
        font-weight: bold;
        font-size: 15px;
        line-height: 18px;
    }

    .jp-card-logo.jp-card-visa:before,
    .jp-card-logo.jp-card-visa:after {
        content: " ";
        display: block;
        width: 100%;
        height: 25%;
    }

    .jp-card-logo.jp-card-visa:before {
        background: #1A1876;
    }

    .jp-card-logo.jp-card-visa:after {
        background: #E79800;
    }

    .jp-card.jp-card-visa.jp-card-identified .jp-card-front:before,
    .jp-card.jp-card-visa.jp-card-identified .jp-card-back:before {
        background-color: #191278;
    }

    .jp-card.jp-card-visa.jp-card-identified .jp-card-logo.jp-card-visa {
        opacity: 1;
    }

    .jp-card-logo.jp-card-mastercard {
        color: white;
        font-weight: bold;
        text-align: center;
        font-size: 9px;
        line-height: 36px;
        z-index: 1;
        text-shadow: 1px 1px rgba(0, 0, 0, 0.6);
    }

    .jp-card-logo.jp-card-mastercard:before,
    .jp-card-logo.jp-card-mastercard:after {
        content: " ";
        display: block;
        width: 36px;
        top: 0;
        position: absolute;
        height: 36px;
        border-radius: 18px;
    }

    .jp-card-logo.jp-card-mastercard:before {
        left: 0;
        background: #FF0000;
        z-index: -1;
    }

    .jp-card-logo.jp-card-mastercard:after {
        right: 0;
        background: #FFAB00;
        z-index: -2;
    }

    .jp-card.jp-card-mastercard.jp-card-identified .jp-card-front .jp-card-logo.jp-card-mastercard,
    .jp-card.jp-card-mastercard.jp-card-identified .jp-card-back .jp-card-logo.jp-card-mastercard {
        box-shadow: none;
    }

    .jp-card.jp-card-mastercard.jp-card-identified .jp-card-front:before,
    .jp-card.jp-card-mastercard.jp-card-identified .jp-card-back:before {
        background-color: #0061A8;
    }

    .jp-card.jp-card-mastercard.jp-card-identified .jp-card-logo.jp-card-mastercard {
        opacity: 1;
    }

    .jp-card-logo.jp-card-maestro {
        color: white;
        font-weight: bold;
        text-align: center;
        font-size: 14px;
        line-height: 36px;
        z-index: 1;
        text-shadow: 1px 1px rgba(0, 0, 0, 0.6);
    }

    .jp-card-logo.jp-card-maestro:before,
    .jp-card-logo.jp-card-maestro:after {
        content: " ";
        display: block;
        width: 36px;
        top: 0;
        position: absolute;
        height: 36px;
        border-radius: 18px;
    }

    .jp-card-logo.jp-card-maestro:before {
        left: 0;
        background: #0064CB;
        z-index: -1;
    }

    .jp-card-logo.jp-card-maestro:after {
        right: 0;
        background: #CC0000;
        z-index: -2;
    }

    .jp-card.jp-card-maestro.jp-card-identified .jp-card-front .jp-card-logo.jp-card-maestro,
    .jp-card.jp-card-maestro.jp-card-identified .jp-card-back .jp-card-logo.jp-card-maestro {
        box-shadow: none;
    }

    .jp-card.jp-card-maestro.jp-card-identified .jp-card-front:before,
    .jp-card.jp-card-maestro.jp-card-identified .jp-card-back:before {
        background-color: #0B2C5F;
    }

    .jp-card.jp-card-maestro.jp-card-identified .jp-card-logo.jp-card-maestro {
        opacity: 1;
    }

    .jp-card-logo.jp-card-dankort {
        width: 60px;
        height: 36px;
        padding: 3px;
        border-radius: 8px;
        border: #000000 1px solid;
        background-color: #FFFFFF;
    }

    .jp-card-logo.jp-card-dankort .dk {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .jp-card-logo.jp-card-dankort .dk:before {
        background-color: #ED1C24;
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        display: block;
        border-radius: 6px;
    }

    .jp-card-logo.jp-card-dankort .dk:after {
        content: '';
        position: absolute;
        top: 50%;
        margin-top: -7.7px;
        right: 0;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 7px 7px 10px 0;
        border-color: transparent #ED1C24 transparent transparent;
        z-index: 1;
    }

    .jp-card-logo.jp-card-dankort .d,
    .jp-card-logo.jp-card-dankort .k {
        position: absolute;
        top: 50%;
        width: 50%;
        display: block;
        height: 15.4px;
        margin-top: -7.7px;
        background: white;
    }

    .jp-card-logo.jp-card-dankort .d {
        left: 0;
        border-radius: 0 8px 10px 0;
    }

    .jp-card-logo.jp-card-dankort .d:before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        display: block;
        background: #ED1C24;
        border-radius: 2px 4px 6px 0px;
        height: 5px;
        width: 7px;
        margin: -3px 0 0 -4px;
    }

    .jp-card-logo.jp-card-dankort .k {
        right: 0;
    }

    .jp-card-logo.jp-card-dankort .k:before,
    .jp-card-logo.jp-card-dankort .k:after {
        content: '';
        position: absolute;
        right: 50%;
        width: 0;
        height: 0;
        border-style: solid;
        margin-right: -1px;
    }

    .jp-card-logo.jp-card-dankort .k:before {
        top: 0;
        border-width: 8px 5px 0 0;
        border-color: #ED1C24 transparent transparent transparent;
    }

    .jp-card-logo.jp-card-dankort .k:after {
        bottom: 0;
        border-width: 0 5px 8px 0;
        border-color: transparent transparent #ED1C24 transparent;
    }

    .jp-card.jp-card-dankort.jp-card-identified .jp-card-front:before,
    .jp-card.jp-card-dankort.jp-card-identified .jp-card-back:before {
        background-color: #0055C7;
    }

    .jp-card.jp-card-dankort.jp-card-identified .jp-card-logo.jp-card-dankort {
        opacity: 1;
    }

    .jp-card {
        font-family: "Helvetica Neue";
        line-height: 1;
        position: relative;
        width: 100%;
        height: 100%;
        min-width: 315px;
        border-radius: 10px;
        -webkit-transform-style: preserve-3d;
        -moz-transform-style: preserve-3d;
        -ms-transform-style: preserve-3d;
        -o-transform-style: preserve-3d;
        transform-style: preserve-3d;
        -webkit-transition: all 400ms linear;
        -moz-transition: all 400ms linear;
        transition: all 400ms linear;
    }

    .jp-card>*,
    .jp-card>*:before,
    .jp-card>*:after {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        font-family: inherit;
    }

    .jp-card.jp-card-flipped {
        -webkit-transform: rotateY(180deg);
        -moz-transform: rotateY(180deg);
        -ms-transform: rotateY(180deg);
        -o-transform: rotateY(180deg);
        transform: rotateY(180deg);
    }

    .jp-card .jp-card-front,
    .jp-card .jp-card-back {
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-transform-style: preserve-3d;
        -moz-transform-style: preserve-3d;
        -ms-transform-style: preserve-3d;
        -o-transform-style: preserve-3d;
        transform-style: preserve-3d;
        -webkit-transition: all 400ms linear;
        -moz-transition: all 400ms linear;
        transition: all 400ms linear;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        overflow: hidden;
        border-radius: 10px;
        background: #DDD;
    }

    .jp-card .jp-card-front:before,
    .jp-card .jp-card-back:before {
        content: " ";
        display: block;
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        border-radius: 10px;
        -webkit-transition: all 400ms ease;
        -moz-transition: all 400ms ease;
        transition: all 400ms ease;
    }

    .jp-card .jp-card-front:after,
    .jp-card .jp-card-back:after {
        content: " ";
        display: block;
    }

    .jp-card .jp-card-front .jp-card-display,
    .jp-card .jp-card-back .jp-card-display {
        color: white;
        font-weight: normal;
        opacity: 0.5;
        -webkit-transition: opacity 400ms linear;
        -moz-transition: opacity 400ms linear;
        transition: opacity 400ms linear;
    }

    .jp-card .jp-card-front .jp-card-display.jp-card-focused,
    .jp-card .jp-card-back .jp-card-display.jp-card-focused {
        opacity: 1;
        font-weight: 700;
    }

    .jp-card .jp-card-front .jp-card-cvc,
    .jp-card .jp-card-back .jp-card-cvc {
        font-family: "Bitstream Vera Sans Mono", Consolas, Courier, monospace;
        font-size: 14px;
    }

    .jp-card .jp-card-front .jp-card-shiny,
    .jp-card .jp-card-back .jp-card-shiny {
        width: 50px;
        height: 35px;
        border-radius: 5px;
        background: #CCC;
        position: relative;
    }

    .jp-card .jp-card-front .jp-card-shiny:before,
    .jp-card .jp-card-back .jp-card-shiny:before {
        content: " ";
        display: block;
        width: 70%;
        height: 60%;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        background: #d9d9d9;
        position: absolute;
        top: 20%;
    }

    .jp-card .jp-card-front .jp-card-logo {
        position: absolute;
        opacity: 0;
        right: 5%;
        top: 8%;
        -webkit-transition: 400ms;
        -moz-transition: 400ms;
        transition: 400ms;
    }

    .jp-card .jp-card-front .jp-card-lower {
        width: 80%;
        position: absolute;
        left: 10%;
        bottom: 30px;
    }

    @media only screen and (max-width: 480px) {
        .jp-card .jp-card-front .jp-card-lower {
            width: 90%;
            left: 5%;
        }
    }

    .jp-card .jp-card-front .jp-card-lower .jp-card-cvc {
        visibility: hidden;
        float: right;
        position: relative;
        bottom: 5px;
    }

    .jp-card .jp-card-front .jp-card-lower .jp-card-number {
        font-family: "Bitstream Vera Sans Mono", Consolas, Courier, monospace;
        font-size: 24px;
        clear: both;
        margin-bottom: 30px;
    }

    .jp-card .jp-card-front .jp-card-lower .jp-card-expiry {
        font-family: "Bitstream Vera Sans Mono", Consolas, Courier, monospace;
        letter-spacing: 0em;
        position: relative;
        float: right;
        width: 25%;
    }

    .jp-card .jp-card-front .jp-card-lower .jp-card-expiry:before,
    .jp-card .jp-card-front .jp-card-lower .jp-card-expiry:after {
        font-family: "Helvetica Neue";
        font-weight: bold;
        font-size: 7px;
        white-space: pre;
        display: block;
        opacity: .5;
    }

    .jp-card .jp-card-front .jp-card-lower .jp-card-expiry:before {
        content: attr(data-before);
        margin-bottom: 2px;
        font-size: 7px;
        text-transform: uppercase;
    }

    .jp-card .jp-card-front .jp-card-lower .jp-card-expiry:after {
        position: absolute;
        content: attr(data-after);
        text-align: right;
        right: 100%;
        margin-right: 5px;
        margin-top: 2px;
        bottom: 0;
    }

    .jp-card .jp-card-front .jp-card-lower .jp-card-name {
        text-transform: uppercase;
        font-family: "Bitstream Vera Sans Mono", Consolas, Courier, monospace;
        font-size: 20px;
        max-height: 45px;
        position: absolute;
        bottom: 0;
        width: 190px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: horizontal;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .jp-card .jp-card-back {
        -webkit-transform: rotateY(180deg);
        -moz-transform: rotateY(180deg);
        -ms-transform: rotateY(180deg);
        -o-transform: rotateY(180deg);
        transform: rotateY(180deg);
    }

    .jp-card .jp-card-back .jp-card-bar {
        background-color: #444;
        background-image: -webkit-linear-gradient(#444, #333);
        background-image: linear-gradient(#444, #333, , , , , , , , );
        width: 100%;
        height: 20%;
        position: absolute;
        top: 10%;
    }

    .jp-card .jp-card-back:after {
        content: " ";
        display: block;
        background-color: #FFF;
        background-image: -webkit-linear-gradient(#FFF, #FFF);
        background-image: linear-gradient(#FFF, #FFF, , , , , , , , );
        width: 80%;
        height: 16%;
        position: absolute;
        top: 40%;
        left: 2%;
    }

    .jp-card .jp-card-back .jp-card-cvc {
        position: absolute;
        top: 40%;
        left: 85%;
        -webkit-transition-delay: 600ms;
        -moz-transition-delay: 600ms;
        transition-delay: 600ms;
    }

    .jp-card .jp-card-back .jp-card-shiny {
        position: absolute;
        top: 66%;
        left: 2%;
    }

    .jp-card .jp-card-back .jp-card-shiny:after {
        content: "This card has been issued by Jesse Pollak and is licensed for anyone to use anywhere for free.AIt comes with no warranty.A For support issues, please visit: github.com/jessepollak/card.";
        position: absolute;
        left: 120%;
        top: 5%;
        color: white;
        font-size: 7px;
        width: 230px;
        opacity: .5;
    }

    .jp-card.jp-card-identified {
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    }

    .jp-card.jp-card-identified .jp-card-front,
    .jp-card.jp-card-identified .jp-card-back {
        background-color: #000;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .jp-card.jp-card-identified .jp-card-front:before,
    .jp-card.jp-card-identified .jp-card-back:before {
        -webkit-transition: all 400ms ease;
        -moz-transition: all 400ms ease;
        transition: all 400ms ease;
        background-image: repeating-linear-gradient(45deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-linear-gradient(135deg, rgba(255, 255, 255, 0.05) 1px, rgba(255, 255, 255, 0) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.03) 4px), repeating-linear-gradient(90deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-linear-gradient(210deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-radial-gradient(circle at 70% 70%, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-radial-gradient(circle at 90% 20%, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-radial-gradient(circle at 15% 80%, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), -webkit-linear-gradient(-245deg, rgba(255, 255, 255, 0) 50%, rgba(255, 255, 255, 0.2) 70%, rgba(255, 255, 255, 0) 90%);
        background-image: repeating-linear-gradient(45deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-linear-gradient(135deg, rgba(255, 255, 255, 0.05) 1px, rgba(255, 255, 255, 0) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.03) 4px), repeating-linear-gradient(90deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-linear-gradient(210deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-radial-gradient(circle at 70% 70%, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-radial-gradient(circle at 90% 20%, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-radial-gradient(circle at 15% 80%, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), linear-gradient(-25deg, rgba(255, 255, 255, 0) 50%, rgba(255, 255, 255, 0.2) 70%, rgba(255, 255, 255, 0) 90%);
        opacity: 1;
    }

    .jp-card.jp-card-identified .jp-card-front .jp-card-logo,
    .jp-card.jp-card-identified .jp-card-back .jp-card-logo {
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
    }

    .jp-card.jp-card-identified.no-radial-gradient .jp-card-front:before,
    .jp-card.jp-card-identified.no-radial-gradient .jp-card-back:before {
        background-image: repeating-linear-gradient(45deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-linear-gradient(135deg, rgba(255, 255, 255, 0.05) 1px, rgba(255, 255, 255, 0) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.03) 4px), repeating-linear-gradient(90deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-linear-gradient(210deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), -webkit-linear-gradient(-245deg, rgba(255, 255, 255, 0) 50%, rgba(255, 255, 255, 0.2) 70%, rgba(255, 255, 255, 0) 90%);
        background-image: repeating-linear-gradient(45deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-linear-gradient(135deg, rgba(255, 255, 255, 0.05) 1px, rgba(255, 255, 255, 0) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.03) 4px), repeating-linear-gradient(90deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), repeating-linear-gradient(210deg, rgba(255, 255, 255, 0) 1px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.04) 3px, rgba(255, 255, 255, 0.05) 4px), linear-gradient(-25deg, rgba(255, 255, 255, 0) 50%, rgba(255, 255, 255, 0.2) 70%, rgba(255, 255, 255, 0) 90%);
    }
</style>
<style>
    #card-icon {
        opacity: 0;
        transform: scale(0.8);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    #card-icon.visible {
        opacity: 1;
        transform: scale(1);
    }
</style>
<div class="form-container">
    <authrize id="authrize" class="authrize"
        style="display: flex; gap: 0.5rem">
        <div class="frows-in" style="position: relative;">
            <div style="display: flex; gap: 0.5rem;">
                <input class="column-left" type="text" id="first_name" name="first_name"
                    placeholder="First Name" />
                <input class="column-right" type="text" id="last_name" name="last_name"
                    placeholder="Surname" />
            </div>
            <input class="mt-1 input-field" id="cardNumber" type="text" name="number" placeholder="Card Number" />
            <div id="card-icon"
                style="font-size: 2rem; transition: 0.3s; position: absolute; top: 65px; right: 5%;">
            </div>
            <span class="error-msg" id="number-error"
                style="font-size: 12px; color: red;"></span>
            <div class="mt-1" style="display: flex; gap: 0.5rem">
                <div style="display: inline-flex; flex-direction: column;">
                    <input class="column-left" id="expiry" type="text"
                        name="expiry" placeholder="MM / YYYY" />
                    <span class="error-msg" id="expiry-error"
                        style="font-size: 12px; color: red;"></span>
                </div>
                <div style="display: inline-flex; flex-direction: column;">
                    <input class="column-right" id="cvc" type="text"
                        name="cvc" placeholder="CCV" />
                    <span class="error-msg" id="cvc-error"
                        style="font-size: 12px; color: red;"></span>
                </div>
            </div>
        </div>
        <div class="card-wrapper"></div>
    </authrize>
</div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/121761/card.js"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/121761/jquery.card.js"></script>
<script id="rendered-js">
    $('authrize').card({
        container: '.card-wrapper',
        width: 280,
        formSelectors: {
            nameInput: 'input[name="first_name"], input[name="last_name"]'
        }
    });
</script>
<script>
    function getCardType(number) {
        number = number.replace(/\D/g, '');
        const patterns = {
            visa: /^4[0-9]{0,}/,
            mastercard: /^(5[1-5][0-9]{0,}|2[2-7][0-9]{0,})/,
            amex: /^3[47][0-9]{0,}/,
            discover: /^(6011|65|64[4-9]|622)/,
            jcb: /^(35[0-9]{0,})/,
            diners: /^3(0[0-5]|[68])[0-9]{0,}/,
            unionpay: /^62[0-9]{0,}/,
        };

        for (let type in patterns) {
            if (patterns[type].test(number)) return type;
        }
        return 'unknown';
    }

    function updateCVCLength(cardNumber) {
        const cardType = getCardType(cardNumber);
        const cvcField = $('#cvc');
        let maxLength = cardType === 'amex' ? 4 : 3;
        cvcField.attr('maxlength', maxLength);
        cvcField.attr('placeholder', maxLength === 4 ? '4-digit CVC' : '3-digit CVC');
    }

    function updateCardIcon(cardType) {
        const iconMap = {
            visa: '<i class="fa fa-cc-visa" style="color:#1a1f71"></i>',
            mastercard: '<i class="fa fa-cc-mastercard" style="color:#eb001b"></i>',
            amex: '<i class="fa fa-cc-amex" style="color:#2e77bc"></i>',
            discover: '<i class="fa fa-cc-discover" style="color:#f76b1c"></i>',
            jcb: '<i class="fa fa-cc-jcb" style="color:#007bc1"></i>',
            diners: '<i class="fa fa-cc-diners-club" style="color:#0069aa"></i>',
            unionpay: '<i class="fa fa-credit-card" style="color:#d81e06"></i>', // no official FA icon
            unknown: '<i class="fa fa-credit-card" style="color:#aaa"></i>',
        };
        $('#card-icon').addClass('visible').html(iconMap[cardType] || iconMap['unknown']);
    }

    function isValidCardNumber(number) {
        number = number.replace(/\D/g, '');
        let sum = 0,
            shouldDouble = false;
        for (let i = number.length - 1; i >= 0; i--) {
            let digit = parseInt(number.charAt(i));
            if (shouldDouble) {
                digit *= 2;
                if (digit > 9) digit -= 9;
            }
            sum += digit;
            shouldDouble = !shouldDouble;
        }
        return sum % 10 === 0 && number.length >= 13 && number.length <= 19;
    }

    function isValidExpiry(expiry) {
        const [month, year] = expiry.split('/').map(str => str.trim());
        if (!month || !year || !/^\d{2}$/.test(month) || !/^\d{4}$/.test(year)) return false;
        const m = parseInt(month, 10);
        const y = parseInt(year, 10);
        const now = new Date();
        const currentMonth = now.getMonth() + 1;
        const currentYear = now.getFullYear();
        return m >= 1 && m <= 12 && (y > currentYear || (y === currentYear && m >= currentMonth));
    }

    function isValidCVC(cvc) {
        return /^\d{3,4}$/.test(cvc.trim());
    }

    function validateInputs() {
        const cardNumber = $('#cardNumber').val();
        const expiry = $('#expiry').val();
        const cvc = $('#cvc').val();
        let valid = true;

        if (!isValidCardNumber(cardNumber)) {
            $('#number-error').text('Invalid card number.');
            valid = false;
        } else {
            $('#number-error').text('');
        }

        if (!isValidExpiry(expiry)) {
            $('#expiry-error').text('Invalid expiry date.');
            valid = false;
        } else {
            $('#expiry-error').text('');
        }

        if (!isValidCVC(cvc)) {
            $('#cvc-error').text('Invalid CVC.');
            valid = false;
        } else {
            $('#cvc-error').text('');
        }

        return valid;
    }

    $(document).ready(function() {
        // Live updates for card number input
        $('#cardNumber').on('input', function() {
            const val = $(this).val();
            const type = getCardType(val);
            updateCVCLength(val);
            updateCardIcon(type);
        });

        // Blur field-level validation (only if value is present)
        $('#cardNumber').on('blur', function() {
            const val = $(this).val();
            if (val && !isValidCardNumber(val)) {
                $('#number-error').text('Invalid card number.');
            } else {
                $('#number-error').text('');
            }
        });

        $('#expiry').on('blur', function() {
            const val = $(this).val();
            if (val && !isValidExpiry(val)) {
                $('#expiry-error').text('Invalid expiry date.');
            } else {
                $('#expiry-error').text('');
            }
        });

        $('#cvc').on('blur', function() {
            const val = $(this).val();
            if (val && !isValidCVC(val)) {
                $('#cvc-error').text('Invalid CVC.');
            } else {
                $('#cvc-error').text('');
            }
        });

        // // Submit validation
        // $('#authrize').on('submit', function(e) {
        //     if (!validateInputs()) {
        //         e.preventDefault();
        //     }
        // });
    });
</script>