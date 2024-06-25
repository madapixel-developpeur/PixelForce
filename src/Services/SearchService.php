<?php

namespace App\Services;

use App\Util\Search\Constants;
use App\Util\GenericUtil;
use App\Util\Search\MyCriteriaParam;
use Doctrine\ORM\QueryBuilder;


class SearchService
{


    public function getWhere($object, MyCriteriaParam $criteriaParam, $params = [], $index = 0): ?array
    {
        $sep = $criteriaParam->getSep() ? $criteriaParam->getSep() : Constants::SEP_AND;
        $criteria = $criteriaParam->getCriteria();
        $where = "1<2";
        for ($i = 0; $i < count($criteria); $i++) {
            $crt = $criteria[$i];
            if (array_key_exists("sep", $crt)) {
                $where .= " " . $sep . " (" + $this->getWhere($object, new MyCriteriaParam($crt["crt"], $criteriaParam->getDefaultAlias(), $crt["sep"]), $params, $index + 1) . ")";
            } else {
                $col = array_key_exists("col", $crt) ? $crt["col"] : $crt["prop"];
                $col = $col;

                $alias = array_key_exists("alias", $crt) ? $crt["alias"] : $criteriaParam->getDefaultAlias();
                if ($alias === null) {
                } else {
                    $col = $alias . "." . $col;
                }


                $value = GenericUtil::getPropertyValue($object, $crt["prop"]);
                if ($value === null) {
                    $considerNull = array_key_exists("consider_null", $crt) ? $crt["consider_null"] : false;
                    if (!$considerNull) continue;
                    $where .= " " . $sep . " " . $col . " IS NULL";
                } else {


                    if (gettype($value) == "string") {
                        $value = trim($value);
                        $considerBlank = array_key_exists("consider_blank", $crt) ? $crt["consider_blank"] : false;
                        if ($value === "" && !$considerBlank) continue;
                    }

                    $caseSensitive = false;
                    $op = array_key_exists("op", $crt) ? $crt["op"] : "=";
                    $paramName = "param_" . $index . "_" . $i;
                    $cond = ":" . $paramName;
                    $caseSensitive = array_key_exists("case_sensitive", $crt) ? $crt["case_sensitive"] : false;
                    if (!$caseSensitive) {
                        $col = "lower(" . $col . ")";
                        $cond = "lower(" . $cond . ")";
                    }

                    if ($op == "LIKE") {
                        $match = array_key_exists("match", $crt) ? $crt["match"] : Constants::MATCH_ALL;
                        if ($match == Constants::MATCH_START || $match == Constants::MATCH_ALL) {
                            $cond = "concat(" . $cond . ",'%')";
                        }
                        if ($match == Constants::MATCH_END || $match == Constants::MATCH_ALL) {
                            $cond = "concat('%', " . $cond . ")";
                        }
                    }

                    $where .= " " . $sep . " " . $col . " " . $op . " " . $cond;
                    $params[$paramName] = $value;
                }
            }
        }

        return [
            "where" => $where,
            "params" => $params
        ];
    }

    public function addOrderBy(QueryBuilder $queryBuilder, array $filter, array $defaults)
    {
        $sort = !isset($filter["sort"]) || $filter["sort"] === null ? $defaults["sort"] : $filter["sort"];
        $direction = !isset($filter["direction"]) || $filter["direction"] === null ? $defaults["direction"] : $filter["direction"];
        $queryBuilder->addOrderBy($sort, $direction);
    }

    public function setAllParameters(QueryBuilder $queryBuilder, array $params)
    {
        foreach ($params as $key => $value) {
            $queryBuilder->setParameter($key, $value);
        }
    }
    public function normalSearch(QueryBuilder $queryBuilder, $search, $field)
    {

        $orX = $queryBuilder->expr()->orX();
        for ($i = 0; $i < count($field); $i++) {
            $orX->add($queryBuilder->expr()->like($field[$i], $search));
        }
        $queryBuilder->andWhere($orX);
    }
}
