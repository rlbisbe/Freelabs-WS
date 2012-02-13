# Servicio web de horarios de laboratorios EPS (FreeLabs)

Este proyecto consta de 2 módulos, un servicio web que puedes emplear para desarrollar tus propios clientes, así como un cliente web para terminales no soportados.

## Servicio Web

El servicio web contiene dos puntos (endpoints) donde puedes solicitar información de los laboratorios:

http://gentle-mist-3984.herokuapp.com/?controller=lab&action=getAll

Devuelve la lista de laboratorios de la EPS

http://gentle-mist-3984.herokuapp.com/?controller=lab&action=getLab&id=24

Donde 24 es el identificador del laboratorio del que quieres obtener la ID, devuelve la lista de turnos ocupados para ese laboratorio esta semana.

Los resultados se devuelven en formato JSON.