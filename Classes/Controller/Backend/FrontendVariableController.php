<?php
declare(strict_types=1);

/*
 * This file is part of PSB Frontend Variables.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace PSB\PsbFrontendVariables\Controller\Backend;

use PSB\PsbFoundation\Attribute\ModuleAction;
use PSB\PsbFoundation\Controller\Backend\AbstractModuleController;
use PSB\PsbFoundation\Service\GlobalVariableProviders\RequestParameterProvider;
use PSB\PsbFoundation\Service\GlobalVariableService;
use PSB\PsbFrontendVariables\Service\FrontendVariableService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use function is_int;

/**
 * Class FrontendVariableController
 *
 * @package PSB\PsbFrontendVariables\Controller\Backend
 */
class FrontendVariableController extends AbstractModuleController
{
    public function __construct(
        protected readonly FrontendVariableService $frontendVariableService,
        ModuleTemplateFactory                      $moduleTemplateFactory,
    ) {
        parent::__construct($moduleTemplateFactory);
    }

    /**
     * @return ResponseInterface
     * @throws ExtensionConfigurationExtensionNotConfiguredException
     * @throws ExtensionConfigurationPathDoesNotExistException
     */
    #[ModuleAction]
    public function listAction(): ResponseInterface
    {
        // Get selected page from page tree
        $pid = GlobalVariableService::get(RequestParameterProvider::class . '.id');

        if (!$this->frontendVariableService->isEnabled()) {
            $this->view->assign('disabled', true);
        } elseif (is_int($pid)) {
            $this->view->assign('variables', $this->frontendVariableService->getVariablesForRootline($pid));
        }

        return $this->htmlResponse();
    }
}
