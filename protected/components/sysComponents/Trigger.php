<?php

class Trigger
{
    private $m_old_flag;
    private $m_flag;

	public function Target( $flag )
	{
		$this->m_old_flag = $this->m_flag;
		$this->m_flag = $flag;
	}
    public function At01() { return ( ( $this->m_old_flag == 0 ) && ( $this->m_flag == 1 ) ); }
    public function At10() { return ( ( $this->m_old_flag == 1 ) && ( $this->m_flag == 0 ) ); }

};