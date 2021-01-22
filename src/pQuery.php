<?php
	class pQuery {

		function __construct($nodes){
			$this->nodes = is_array($nodes) ? $nodes : array($nodes);
		}

		static function fromHTML($html){

			libxml_use_internal_errors(true);

			$doc = new \DOMDocument();
			$doc->loadHTML($html);

			return new pQuery($doc);
		}


		#
		# this is the meat of the class.
		# the equivalent guts of jQuery can be found here:
		# https://github.com/jquery/jquery/blob/master/src/selector.js
		#

		function find($path){

			$query = $this->parseQuery($path);

			$nodes = $this->nodes;

			foreach ($query as $step){
				# perform filtering
				$new_nodes = array();

				if (isset($step['tag'])){
					foreach ($nodes as $node){
						$subs = $node->getElementsByTagName($step['tag']);
						foreach ($subs as $candidate){
							if ($this->matchNode($candidate, $step)){
								$new_nodes[] = $candidate;
							}
						}
					}
				}else{
					foreach ($nodes as $node){
						$this->spiderChildren($node, $step, $new_nodes);
					}
				}

				$nodes = $new_nodes;
			}

			return $nodes;
		}


		private function parseQuery($path){

			$query = array();

			$tag = '[0-9a-zA-Z]+'; # https://www.w3.org/TR/2011/WD-html5-20110525/syntax.html#elements-0
			$class = '-?[_a-zA-Z]+[_a-zA-Z0-9-]*'; # http://www.w3.org/TR/CSS21/grammar.html#scanner
			$id = '\S+';

			$parts = explode(' ', StrToLower($path));
			foreach ($parts as $part){

				if (preg_match("!^({$tag})\$!", $part, $m)){
					$query[] = [
						'tag' => $m[1],
					];
					continue;
				}

				if (preg_match("!^({$tag})\.({$class})\$!", $part, $m)){
					$query[] = [
						'tag' => $m[1],
						'class' => $m[2],
					];
					continue;
				}

				if (preg_match("!^({$tag})\#({$id})\$!", $part, $m)){
					$query[] = [
						'tag' => $m[1],
						'id' => $m[2],
					];
					continue;
				}

				if (preg_match("!^\.({$class})\$!", $part, $m)){
					$query[] = [
						'class' => $m[1],
					];
					continue;
				}

				if (preg_match("!^\#({$id})\$!", $part, $m)){
					$query[] = [
						'id' => $m[1],
					];
					continue;
				}

				die("Unable to parse query");
			}

			return $query;
		}

		private function matchNode($node, $step){

			#
			# does $node satisfy the filter conditions in $step?
			#

			if (isset($step['class'])){
				$classes = $node->getAttribute('class');
				$parts = preg_split('!\s+!', $classes);
				$matched = false;
				foreach ($parts as $test){
					if ($test === $step['class']){
						$matched = true;
						break;
					}
				}
				if (!$matched) return false;
			}


			if (isset($step['id'])){
				$id = $node->getAttribute('id');
				if ($id !== $step['id']) return false;
			}

			return true;
		}

		private function spiderChildren($node, $step, &$matches){

			if ($node->nodeType == 1){
				if ($this->matchNode($node, $step)){
					$matches[] = $node;
				}
			}

			foreach ($node->childNodes as $child){
				if ($child->nodeType == 1){
					$this->spiderChildren($child, $step, $matches);
				}
			}
		}
	}
