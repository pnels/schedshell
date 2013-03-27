require 'open-uri'
require 'mysql'

###
# TODO:
#   - discern whether or not prereqs are required (like MATH140 -> MATH115 -> MATH113) as most people test out
#   - possibly display GPA graph, in addition to course description? or something
#   - grab course title (add MySQL row) and display in popover istead of course code
#   - handle invalid searches: elakjfa
#   - handle invalid courses: CMSC999
#   - course auto-completion (after they type CMSC4 in search, list all 400 lvl courses?)
#   - comic sans button!
###

my = Mysql::new('localhost', 'hardshell', 'd0ntgue55m3', 'hardshell')

departments = Array.new

deps = open('https://ntst.umd.edu/soc/').read
deps.scan(/<span class="prefix-abbrev push_one two columns">(\w{4})<\/span>\s+<span class="prefix-name nine columns">(.+?)<\/span>/) { |abbr,full|
  departments << abbr
  my.query("INSERT IGNORE INTO department_info(abbr, name) VALUES('" + abbr + "', '" + Mysql.escape_string(full) + "')")
}

dep_count = 0
course_count = 0

departments.each { |abbr|
  dep_count = dep_count + 1

  #using new testudo
  page = open('https://ntst.umd.edu/soc/all-courses-search.html?course=' + abbr + '&term=201308').read

  # extract each course
  page.scan(/<div id="(\w{4}\d{3}\w?)" class="course">(.+?)\s+<\/div>\s+<\/div>\s+<\/div>\s+<\/div>\s+<\/div>\s+<\/div>/m) { |id,info|
    course_count = course_count + 1
    #don't need to worry about SQLi b/c we're restrictive with our regexps
    
    #from the new testudo page: can grab 'course-min-credits' or 'course-max-credits'
    #credits will only ever by 1 digit...right?
    credits = info.scan(/<span class="course-min-credits">(\d)<\/span>/).join("")
    
    my.query("INSERT IGNORE INTO course_info(name, credits, department) VALUES('" + id + "', '" + credits + "', '" + abbr + "')")
    my.commit # not sure if needed
    #puts "INSERTING: #{id} (#{credits})"
  
    #search until first period, so we don't grab corequisite or orther courses by accident
    info.scan(/<div class="approved-course-text">Prerequisite:(.+?)\./) { |text| #text is an array for some reason?? not a string??
      my.query("UPDATE course_info SET prereqs='" + text[0].scan(/\w{4}\d{3}\w?/).join(", ") + "' WHERE name='" + id + "'")
      #puts "\tUPDATING with prereqs: #{text[0].scan(/\w{4}\d{3}\w?/).join(", ").inspect}"
    }

    #same as above, but for corequisites
    info.scan(/<div class="approved-course-text">(?:Prerequisite:.+?)*Corequisite:(.+?)\./) { |text| #text is an array for some reason?? not a string??
      my.query("UPDATE course_info SET coreqs='" + text[0].scan(/\w{4}\d{3}\w?/).join(", ") + "' WHERE name='" + id + "'")
      #puts "\tUPDATING with coreqs: #{text[0].scan(/\w{4}\d{3}\w?/).join(", ").inspect}"
    }

    #pull course description
    info.scan(/(?:<div class="approved-course-text">(?:Prerequisite|Corequisite|Restriction|Also).+?)*<div class="approved-course-text">(.+?)<\/div>/m) { |desc| #same issue as above...1 element array?
      my.query("UPDATE course_info SET description='" + Mysql.escape_string( desc[0] ) + "' WHERE name='" + id + "'")
    }
  }
}

puts "Added #{course_count} courses in #{dep_count} departments."
