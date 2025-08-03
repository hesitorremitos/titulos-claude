# Project Purpose

This is a Laravel 12 application for digitalizing academic titles for the Universidad Autónoma Tomás Frías (UATF) Department of Titles in Potosí, Bolivia. The system replaces manual physical file management with a digital system for registering, searching, and managing academic titles.

## Target Title Types
- Academic Diplomas (Diplomas Académicos)  
- Professional Titles (Títulos Profesionales) 
- High School Diplomas (Diplomas de Bachiller)

## Core Business Goal
Replace manual physical file management with a digital system that allows staff to:
- Register academic titles with personal data integration via University API
- Search and manage titles efficiently
- Control access based on user roles (Personal, Jefe, Administrador)
- Maintain audit trails for accountability
- Handle both digitalized and pending digitalization states for lost documents

## Key Business Rules
- CI (Carnet de Identidad) is the unique identifier for people
- One title per type, per person, per career
- Staff can only access titles they registered
- Jefe can view all titles but cannot modify
- Administrator has full system access
- All modifications tracked with user and timestamp