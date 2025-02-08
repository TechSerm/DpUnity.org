<?php

namespace App\Services\FormBuilder;

use Filament\Forms\Components;

class FormComponent
{
    private string $type;
    private ?string $key = null;
    private ?string $label = null;
    private ?string $helperText = null;
    private array $rules = [];
    private int $width = 12;
    private array $fields = [];
    private int $priority = 1;
    private mixed $default = null;
    private ?string $group = null;
    private ?string $subgroup = null;
    private bool $isMultiple = false;
    private bool $reorderable = false;
    private bool $hasImageEditor = false;
    private int $maxFiles = 1;
    private ?string $panelLayout = null;
    private ?string $directory = null;

    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Set the component type.
     *
     * @param string $type
     * @return self
     */
    private function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Create a text input component.
     * @return self
     */
    public function textInput(): self
    {
        return $this->setType('text');
    }

    /**
     * Create a textarea component.
     * @return self
     */
    public function textArea(): self
    {
        return $this->setType('textarea');
    }

    /**
     * Create an email input component.
     * @return self
     */
    public function email(): self
    {
        return $this->setType('email');
    }

    /**
     * Create a URL input component.
     * @return self
     */
    public function url(): self
    {
        return $this->setType('url');
    }

    /**
     * Create an image upload component.
     * @return self
     */
    public function image(): self
    {
        return $this->setType('image');
    }

    /**
     * Create a number input component.
     * @return self
     */
    public function number(): self
    {
        return $this->setType('number');
    }

    /**
     * Create a rich editor component.
     * @return self
     */
    public function richEditor(): self
    {
        return $this->setType('rich_editor');
    }

    /**
     * Create a repeater component.
     * @return self
     */
    public function repeater(): self
    {
        return $this->setType('repeater');
    }

    /**
     * Set the key for the form component.
     * @param string $key
     * @return self
     */
    public function key(string $key): self
    {
        $this->key = $key;
        return $this;
    }

    /**
     * Set the label for the form component.
     * @param string $label
     * @return self
     */
    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Set the help text for the form component.
     * @param string $helperText
     * @return self
     */
    public function helperText(string $helperText): self
    {
        $this->helperText = $helperText;
        return $this;
    }

    /**
     * Set validation rules for the form component.
     * @param array $rules
     * @return self
     */
    public function rules(array $rules): self
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * Set the column width for the form component.
     * @param int $width
     * @return self
     */
    public function width(int $width): self
    {
        $this->width = $width;
        return $this;
    }

    /**
     * Set the group for the form component.
     * @param string $group
     * @return self
     */
    public function group(string $group): self
    {
        $this->group = $group;
        return $this;
    }

    /**
     * Set the subgroup for the form component.
     * @param string $subgroup
     * @return self
     */
    public function subgroup(string $subgroup): self
    {
        $this->subgroup = $subgroup;
        return $this;
    }

    /**
     * Set the priority for the form component.
     * @param int $priority
     * @return self
     */
    public function priority(int $priority): self
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * Set the default value for the form component.
     * @param mixed $default
     * @return self
     */
    public function default(mixed $default): self
    {
        $this->default = $default;
        return $this;
    }

    /**
     * Set nested fields for the form component.
     * @param array $fields
     * @return self
     */
    public function fields(array $fields): self
    {
        $this->fields = $fields;
        return $this;
    }

    public function reorderable(): self
    {
        $this->reorderable = true;
        return $this;
    }

    /**
     * Check if the component is a text type.
     * @return bool
     */
    public function isTextInput(): bool
    {
        return in_array($this->type, ['text', 'url', 'email']);
    }

    public function isTextArea(): bool
    {
        return $this->type === 'textarea';
    }

    public function isUrl(): bool
    {
        return $this->type === 'url';
    }

    public function isEmail(): bool
    {
        return $this->type === 'email';
    }

    public function isImage(): bool
    {
        return $this->type === 'image';
    }

    public function isRepeater(): bool
    {
        return $this->type === 'repeater';
    }

    public function isRichEditor(): bool
    {
        return $this->type === 'rich_editor';
    }

    public function isFile(): bool
    {
        return $this->type === 'file';
    }

    public function isString(): bool
    {
        return $this->isTextInput() || $this->isTextArea() || $this->isRichEditor();
    }

    public function isArray(): bool
    {
        return $this->isRepeater() || $this->isMultiple();
    }

    public function getCastType(): string
    {
        return $this->isArray() ? 'array' : 'string';
    }

    public function multiple(): self
    {
        $this->isMultiple = true;
        return $this;
    }

    public function directory(string $directory): self
    {
        $this->directory = $directory;
        return $this;
    }

    public function getDirectory(): ?string
    {
        return $this->directory;
    }

    public function imageEditor(): self
    {
        $this->hasImageEditor = true;
        return $this;
    }

    public function maxFiles(int $maxFiles): self
    {
        $this->maxFiles = $maxFiles;
        return $this;
    }

    public function panelLayout(string $panelLayout): self
    {
        $this->panelLayout = $panelLayout;
        return $this;
    }

    /**
     * Dynamic type check methods.
     * @param string $type
     * @return bool
     */
    public function isType(string $type): bool
    {
        return $this->type === $type;
    }

    /**
     * Getters for various properties.
     */
    public function getGroupName(): ?string
    {
        return $this->group;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getSubgroupName(): ?string
    {
        return $this->subgroup;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getHelperText(): ?string
    {
        return $this->helperText;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getDefaultValue(): mixed
    {
        return $this->default;
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function isMultiple(): bool
    {
        return $this->isMultiple;
    }

    public function isReorderable(): bool
    {
        return $this->reorderable;
    }

    public function hasImageEditor(): bool
    {
        return $this->hasImageEditor;
    }

    public function getMaxFiles(): int
    {
        return $this->maxFiles;
    }

    public function getPanelLayout(): ?string
    {
        return $this->panelLayout;
    }

    public function buildFilamentFormComponent(): ?Components\Component
    {
        return (new FilamentFormComponentBuilder())->build($this);
    }
}
