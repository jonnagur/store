<?php

class ToArray
{
    public function toArray( $data )
    {
        if ( is_object( $data ) )
        {
            $class  = new ReflectionClass( get_class( $data ) ); 
            
            return $class->getDefaultProperties();
        }

        else
        {
            return $data;
        }
    }
}