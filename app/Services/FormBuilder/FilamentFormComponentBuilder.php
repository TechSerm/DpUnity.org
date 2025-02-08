<?php

namespace App\Services\FormBuilder;

use Illuminate\Support\Str;
use Filament\Forms\Components;

class FilamentFormComponentBuilder
{
    public function build(FormComponent $formComponent): ?Components\Component
    {
        $component = $this->createComponent($formComponent);
        if (!$component) {
            return null;
        }

        $this->applyCommonAttributes($formComponent, $component);

        return $component->columnSpan($formComponent->getWidth());
    }

    private function createComponent(FormComponent $formComponent): ?Components\Component
    {
        if ($formComponent->isTextInput()) {
            return $this->buildTextInput($formComponent);
        } elseif ($formComponent->isTextArea()) {
            return Components\Textarea::make($formComponent->getKey());
        } elseif ($formComponent->isImage()) {
            return $this->buildImageUpload($formComponent);
        } elseif ($formComponent->isRichEditor()) {
            return Components\RichEditor::make($formComponent->getKey())
            ->fileAttachmentsDirectory($formComponent->getDirectory());
        } elseif ($formComponent->isRepeater()) {
           return $this->buildRepeater($formComponent);
        }

        return null;
    }

    private function buildTextInput(FormComponent $formComponent): Components\TextInput
    {
        $component = Components\TextInput::make($formComponent->getKey());

        if ($formComponent->isUrl()) {
            $component->url();
        } elseif ($formComponent->isEmail()) {
            $component->email();
        }

        return $component;
    }

    private function buildImageUpload(FormComponent $formComponent): Components\FileUpload
    {
        return Components\FileUpload::make($formComponent->getKey())
            ->image()
            ->directory($formComponent->getDirectory())
            ->maxFiles($formComponent->getMaxFiles())
            ->multiple($formComponent->isMultiple())
            ->reorderable($formComponent->isReorderable())
            ->imageEditor($formComponent->hasImageEditor())
            ->panelLayout($formComponent->getPanelLayout());
    }

    private function buildRepeater(FormComponent $formComponent): Components\Repeater
    {
        return Components\Repeater::make($formComponent->getKey())
            ->collapsible()
            ->persistCollapsed()
            ->reorderable()
            ->itemLabel(fn(array $state): ?string => $state['title'] ?? null)
            ->schema(array_map(
                fn(FormComponent $fieldComponent) => $this->build($fieldComponent),
                $formComponent->getFields()
            ));
    }

    private function applyCommonAttributes(FormComponent $formComponent, Components\Component $component): void
    {
        if ($label = $formComponent->getLabel()) {
            $component->label($label);
        }

        if ($helperText = $formComponent->getHelperText()) {
            $component->helperText($helperText);
        }

        if ($rules = $formComponent->getRules()) {
            $component->rules($rules);
        }
    }
}
