<?php

namespace Statamic\Addons\Suggest;

use Statamic\API\Str;
use Statamic\Extend\Controller;
use Statamic\Exceptions\ResourceNotFoundException;

class SuggestController extends Controller
{
    /**
     * The mode class
     *
     * @var \Statamic\Addons\Suggest\Mode
     */
    protected $mode;

    /**
     * Associative array of suggestions with label and value keys.
     *
     * @var array
     */
    protected $suggestions;

    /**
     * Get the suggestions
     *
     * @return array
     * @throws \Statamic\Exceptions\FatalException
     */
    public function suggestions()
    {
        return $this->mode()->suggestions();
    }

    /**
     * Get the suggestion mode
     *
     * @return \Statamic\Addons\Suggest\Mode
     * @throws \Statamic\Exceptions\FatalException
     */
    private function mode()
    {
        $mode = request()->input('type');

        if ($mode === 'suggest') {
            $mode = $this->request->input('mode', 'options');
        }

        // An addon may contain multiple modes. You may specify a "secondary" mode by delimiting with a dot.
        // For example, "bacon.bits" would reference the "BitsSuggestMode" in the "Bacon" addon.
        if (Str::contains($mode, '.')) {
            list($addon, $name) = explode('.', $mode);
        } else {
            $addon = $name = $mode;
        }

        $name = Str::studly($name);
        $addon = Str::studly($addon);
        $root = "Statamic\\Addons\\$addon";

        // First, native suggest modes.
        if (class_exists($native = 'Statamic\Addons\Suggest\Modes\\' . $name . 'Mode')) {
            return $this->initMode($native);
        }

        // Suggest Modes may be stored in the root of the addon directory, named using YourAddonSuggestMode.php or
        // secondary ones may be named SecondarySuggestMode.php. Classes in the root will take precedence.
        if (class_exists($rootClass = "{$root}\\{$name}SuggestMode")) {
            return $this->initMode($rootClass);
        }

        // Alternatively, Suggest Modes may be placed in a "SuggestModes" namespace.
        if (class_exists($namespacedClass = "{$root}\\SuggestModes\\{$name}SuggestMode")) {
            return $this->initMode($namespacedClass);
        }

        throw new ResourceNotFoundException("Could not find files to load the `{$mode}` suggest mode.");
    }

    private function initMode($class)
    {
        return app($class);
    }
}
