using Suppressor
@suppress begin
    using SimpleHypergraphs
end
# using SimpleHypergraphs

function build_hg(path)

    nodes = Dict{Int,Int}()
    nodes_per_edge = Dict{Int,Vector{Int}}()

    hg = Hypergraph(0,0)

    for line in eachline(path)
        # split elemnts of the line by comma
        d = split(line, ",")
        vs = map(x -> parse(Int,(strip(replace(x, r"\[|\]" => "")))), d)
        for v in vs
            if !haskey(nodes, v)
                v_id = SimpleHypergraphs.add_vertex!(hg)
                push!(nodes, v=>v_id)
            end
        end
        # add he 
        vertices = Dict{Int, Bool}(nodes[v] => true for v in vs)
        he_id = SimpleHypergraphs.add_hyperedge!(hg; vertices = vertices)
        push!(nodes_per_edge, he_id => vs)  
    end

    return hg, nodes, nodes_per_edge
end

function infos(hg)
    nodes = nhv(hg)
    edges = nhe(hg) 
    return (nodes, edges)
end

function collect_infos(path)
    hg = build_hg(path)[1]
    info = infos(hg)
    return info
end
