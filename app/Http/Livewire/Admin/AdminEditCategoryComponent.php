<?php

namespace App\Http\Livewire\Admin;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;

class AdminEditCategoryComponent extends Component
{
    public $category_slug;
    public $category_id;
    public $name;
    public $slug;

    public function mount( $category_slug){
        $this->category_slug=$category_slug;
        $category= Category::where('slug',$category_slug)->first();
        $this->category_id=$category->id;
        $this->category_name=$category->name;
        $this->slug=$category->slug;
    }
    public function generateslug(){
        $this->slug=Str::slug($this->name);
    }

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'name'=>'required',
            'slug'=>'required|unique:categories'

        ]);

    }
    
    public function UpdateCategory()
    {
        $this->validate([
            'name'=>'required',
            'slug'=>'required|unique:categories'
        ]);
        $category= Category::find($this->category_id);
        $category->name= $this->name;
        $category->slug= $this->slug;
        $category->save();
        Session()->flash('message','Category has been updated succesfully');

    }




    public function render()
    {
        return view('livewire.admin.admin-edit-category-component')->layout('layouts.base');
    }
}
