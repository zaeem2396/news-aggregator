<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerAcRrWRx\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerAcRrWRx/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerAcRrWRx.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerAcRrWRx\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerAcRrWRx\App_KernelDevDebugContainer([
    'container.build_hash' => 'AcRrWRx',
    'container.build_id' => '36d9e2e5',
    'container.build_time' => 1733568473,
    'container.runtime_mode' => \in_array(\PHP_SAPI, ['cli', 'phpdbg', 'embed'], true) ? 'web=0' : 'web=1',
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerAcRrWRx');