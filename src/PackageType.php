<?php

namespace Seed;

enum PackageType: string
{
    case TYPE_ZIP = 'zip';
    case TYPE_GZIP = 'tar.gz';
    case TYPE_TAR = 'tar';
}
