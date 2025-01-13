<?php
namespace Classes;

class Subject {
    private $observers = [];

    // Añadir un observador
    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    // Eliminar un observador
    public function detach(Observer $observer) {
        $this->observers = array_filter($this->observers, fn($obs) => $obs !== $observer);
    }

    // Notificar a todos los observadores
    public function notifyObservers($event, $data) {
        foreach ($this->observers as $observer) {
            $observer->notify($event, $data);
        }
    }
}