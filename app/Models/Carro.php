<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    use HasFactory;
    protected $fillable = ['modelo_id', 'placa', 'disponivel', 'km'];

    public function rules() {
        return [
            'modelo_id' => 'exists:modelos,id',
            'placa' => 'required|unique:carros,placa,'.$this->id,
            'disponivel' => 'required',
            'km' => 'required'
        ];
    }
    
    public function feedback() {
        return [
            'placa.unique' => 'Já existe um modelo cadastrado com essa placa',
            'required' => 'O campo :attribute é obrigatório'
        ];
    }

    public function modelo() {
        return $this->belongsTo('App\Models\Modelo');
    }
}
