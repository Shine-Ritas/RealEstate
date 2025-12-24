<?php

namespace App\Livewire\Property;

use App\Enums\PropertyContactEnum;
use App\Enums\PropertyContactTypeEnum;
use App\Models\LocationElement;
use App\Models\Property;
use App\Models\PropertyContact;
use App\Models\PropertyLocationElement;
use Livewire\Component;

class GeoForm extends Component
{

    public Property $property;
    public mixed $locationElements ;

    public mixed $propertyContactsTypes;

    public mixed $providerTypes;

    public string $fullText ;

    public string $distance;

    public string|int $selectedLocationElement;

    public string|int $selectedPropertyContactType;
    public PropertyContactEnum $selectedProviderType;

    public mixed $propertyLocationElements;
    public mixed $propertyContacts;
    public string $text;
    public string $url;


    public function mount(Property $property): void
    {
        $property->load('locationElements','contacts');
        $this->property = $property;
        $this->locationElements = convert_to_dropdown(LocationElement::all(), 'name', 'id','icon');
        $this->propertyLocationElements = $property->locationElements->load('locationElement');
        $this->propertyContacts = $property->contacts;
        $this->propertyContactsTypes = PropertyContactTypeEnum::dropdown();
        $this->providerTypes = PropertyContactEnum::dropdown(true);
    }

    public function rules()
    {
        return [
            'selectedLocationElement' => 'required|exists:location_elements,id',
            'fullText' => 'required|string|max:255',
            'distance' => 'required|string',
        ];
    }

    public function save()
    {
        $this->validate();

        PropertyLocationElement::create([
            'location_element_id' => $this->selectedLocationElement,
            'name' => $this->fullText,
            'details' => $this->fullText,
            'distance' => $this->distance,
            'property_id' => $this->property->id,
        ]);

        $this->property->refresh();
        $this->propertyLocationElements = $this->property->locationElements->load('locationElement');

        session()->flash('success', 'Location Element added successfully.');
    }

    public function saveContact()
    {

        $this->validate([
            'text' => 'required|string|max:255',
            'url' => 'required|string|max:255', 
            'selectedPropertyContactType' => 'required',
            'selectedProviderType' => 'required',
        ]);

        PropertyContact::create([
            'property_id' => $this->property->id,
            'type' => $this->selectedPropertyContactType,
            'contact_type' => $this->selectedProviderType->value,
            'text' => $this->text,
            'url' => $this->url,
            'icon' => $this->selectedProviderType->icon(),
        ]);

        $this->property->refresh();
        $this->propertyContacts = $this->property->contacts;
        session()->flash('success', 'Contact added successfully.');
    }

    public function delete(PropertyLocationElement $propertyLocationElement)
    {
        $propertyLocationElement->delete();
        $this->property->refresh();
        $this->propertyLocationElements = $this->property->locationElements->load('locationElement');
        session()->flash('success', 'Location Element deleted successfully.');
    }

    public function render()
    {
        return view('livewire.property.geo-form')->layout('components.layouts.app', [
                'header' => "Geo Location Form",
                'subtitle' => 'Add Nearby Location Elements',
            ]);
    }
}
