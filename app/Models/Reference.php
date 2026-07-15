<?php

namespace App\Models;

use App\Core\BaseModel;
use PDO;

class Reference extends BaseModel {
    protected string $table = "site_references";

    public function getBySiteId(int $siteId): array {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE `site_id` = :site_id ORDER BY `sort_order` ASC");
        $stmt->execute(["site_id" => $siteId]);
        return $stmt->fetchAll();
    }

    public function sync(int $siteId, array $items): void {
        $this->db->prepare("DELETE FROM `{$this->table}` WHERE `site_id` = :site_id")
                 ->execute(["site_id" => $siteId]);

        $stmt = $this->db->prepare("
            INSERT INTO `{$this->table}`
                (`site_id`, `name`, `name_en`, `photo`, `description`, `description_en`, `phone`, `email`, `sort_order`)
            VALUES (:site_id, :name, :name_en, :photo, :description, :description_en, :phone, :email, :sort_order)
        ");

        foreach ($items as $i => $item) {
            if (empty($item["name"])) continue;
            $stmt->execute([
                "site_id"        => $siteId,
                "name"           => $item["name"] ?? "",
                "name_en"        => $item["name_en"] ?? null,
                "photo"          => $item["photo"] ?? null,
                "description"    => $item["description"] ?? null,
                "description_en" => $item["description_en"] ?? null,
                "phone"          => $item["phone"] ?? null,
                "email"          => $item["email"] ?? null,
                "sort_order"     => (int)$i,
            ]);
        }
    }
}
