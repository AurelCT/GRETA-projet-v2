<?php
namespace App\Entity;

final class Formation
{
    private int $id;
    private string $formationTitle;

     /**
     * @param array $category
     */
    public function hydrate(array $formation): Formation
    {
        $this->id = $formation['id_formation'];
        $this->formationTitle = $formation['titreFormation'];
                
        return $this;
    }

        /**
     * on récupère la valeur de formationtitle
     *
     * @return string
     */
    public function getformationTitle(): string
    {
        return $this->formationTitle;
    }

    /**
     * Set the value of formationTitle
     *
     * @param string $formationTitle
     *
     * @return self
     */
    public function setLabel(string $formationTitle): self
    {
        $this->formationTitle = $formationTitle;

        return $this;
    }

    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}