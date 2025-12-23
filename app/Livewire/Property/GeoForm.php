<?php

namespace App\Livewire\Property;

use App\Models\LocationElement;
use App\Models\Property;
use App\Models\PropertyLocationElement;
use Livewire\Component;

class GeoForm extends Component
{

    public Property $property;
    public mixed $locationElements ;

    public string $fullText ;

    public string $distance;

    public string|int $selectedLocationElement;

    public mixed $propertyLocationElements;


    public function mount(Property $property): void
    {
        $property->load('locationElements');
        $this->property = $property;
        $this->locationElements = convert_to_dropdown(LocationElement::all(), 'name', 'id','icon');
        $this->propertyLocationElements = $property->locationElements->load('locationElement');
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
