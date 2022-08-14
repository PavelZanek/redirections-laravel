<?php

namespace PavelZanek\RedirectionsLaravel\Enums;

enum StatusCode: int {
    case MovedPermanently = 301;
    case Found = 302;
    case SeeOther = 303;
    case NotModified = 304;
    case TemporaryRedirect = 307;
    case PermanentRedirect = 308;
}