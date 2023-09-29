<?php
declare(strict_types=1);

/*
 * This file is part of PSB Frontend Variables.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace PSB\PsbFrontendVariables\Data;

use PSB\PsbFoundation\Data\AbstractExtensionInformation;
use PSB\PsbFoundation\Data\ModuleConfiguration;
use PSB\PsbFrontendVariables\Controller\Backend\FrontendVariableController;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ExtensionInformation
 *
 * @package PSB\PsbFrontendVariables\Data
 */
class ExtensionInformation extends AbstractExtensionInformation
{
    public function __construct()
    {
        parent::__construct();
        $this->addModule(
            GeneralUtility::makeInstance(
                ModuleConfiguration::class,
                controllers        : [FrontendVariableController::class],
                key                : $this->buildModuleKeyPrefix() . 'frontendVariables',
                navigationComponent: '@typo3/backend/page-tree/page-tree-element',
                parentModule       : 'web',
            )
        );
    }
}
